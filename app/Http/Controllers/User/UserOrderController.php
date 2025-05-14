<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserOrderController extends Controller
{
    public function form()
    {
        $user = Auth::user();
        $cartItems = Cart::with('variant.product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart.list')->with('error', 'カートが空です。');
        }

        return view('user.order.form', [
        'user' => $user,
        'cartItems' => $cartItems,
        'payjp_public_key' => config('payjp.public_key'),
    ]);
    }

    public function confirm(Request $request)
    {
        $user = Auth::user();

        $shippingAddress = $request->address_option === 'saved'
            ? $user->address
            : $request->shipping_address;

        $cartItems = Cart::with('variant.product')->where('user_id', $user->id)->get();
        $total = $cartItems->sum(fn($item) => $item->variant->product->price * $item->quantity);

        $coupon = null;
        $discount = 0;
        if ($request->filled('coupon_code')) {
            $coupon = Coupon::where('code', $request->coupon_code)
                ->where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('valid_from')->orWhere('valid_from', '<=', now());
                })
                ->where(function ($q) {
                    $q->whereNull('valid_until')->orWhere('valid_until', '>=', now());
                })
                ->first();

            if ($coupon && $total >= $coupon->min_order_amount) {
                $discount = $coupon->discount_type === 'percent'
                    ? intval($total * $coupon->discount_value / 100)
                    : $coupon->discount_value;
                $discount = min($discount, $total);
            }
        }

        session([
            'order_data' => [
                'shipping_address' => $shippingAddress,
                'payment_method' => $request->payment_method,
                'coupon_code' => $coupon?->code,
            ]
        ]);

        $paymentMethodLabels = [
            'credit' => 'クレジットカード',
            'e_money' => '電子マネー',
            'bank_transfer' => '銀行振込',
        ];

        $paymentMethod = $request->payment_method;
        $paymentMethodLabel = $paymentMethodLabels[$paymentMethod];

        return view('user.order.confirm', [
            'user' => $user,
            'cartItems' => $cartItems,
            'shippingAddress' => $shippingAddress,
            'coupon' => $coupon,
            'discount' => $discount ?? 0,
            'total' => $total,
            'paymentMethodLabel' => $paymentMethodLabel,
        ]);
    }

    public function showConfirm()
    {
        $orderData = session('order_data');

        if (!$orderData) {
            return redirect()->route('user.order.form')->with('error', '注文情報が見つかりません。');
        }

        $user = Auth::user();
        $cartItems = Cart::with('variant.product')->where('user_id', $user->id)->get();

        $coupon = null;
        $discount = 0;
        if (!empty($orderData['coupon_code'])) {
            $coupon = Coupon::where('code', $orderData['coupon_code'])
                ->where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('valid_from')->orWhere('valid_from', '<=', now());
                })
                ->where(function ($q) {
                    $q->whereNull('valid_until')->orWhere('valid_until', '>=', now());
                })
                ->first();

            if ($coupon && $cartItems->sum(fn($item) => $item->variant->product->price * $item->quantity) >= $coupon->min_order_amount) {
                $total = $cartItems->sum(fn($item) => $item->variant->product->price * $item->quantity);
                $discount = $coupon->discount_type === 'percent'
                    ? intval($total * $coupon->discount_value / 100)
                    : $coupon->discount_value;
                $discount = min($discount, $total);
            }
        }

        $paymentMethodLabels = [
            'credit' => 'クレジットカード',
            'e_money' => '電子マネー',
            'bank_transfer' => '銀行振込',
        ];

        $paymentMethodLabel = $paymentMethodLabels[$orderData['payment_method']] ?? '未選択';

        $total = $cartItems->sum(fn($item) => $item->variant->product->price * $item->quantity);

        return view('user.order.confirm', [
            'cartItems' => $cartItems,
            'shippingAddress' => $orderData['shipping_address'],
            'paymentMethodLabel' => $paymentMethodLabel,
            'coupon' => $coupon,
            'discount' => $discount ?? 0,
            'total' => $total,
        ]);
    }

    public function complete()
    {
        \Log::debug('complete method reached');

        $user = Auth::user();
        \Log::debug('Authenticated user', ['user_id' => $user?->id]);

        $orderData = session('order_data');
        if (!$orderData) {
            \Log::debug('Order data not found in session');
            return redirect()->route('user.order.form')->with('error', '注文情報が見つかりません。');
        }

        $cartItems = Cart::with('variant')->where('user_id', $user->id)->get();
        \Log::debug('Cart items fetched', ['count' => $cartItems->count()]);

        if ($cartItems->isEmpty()) {
            \Log::debug('Cart is empty');
            return redirect()->route('user.cart.list')->with('error', 'カートが空です。');
        }

        $paymentMethodLabels = [
            'credit' => 'クレジットカード',
            'e_money' => '電子マネー',
            'bank_transfer' => '銀行振込',
        ];

        DB::beginTransaction();

        try {
            $total = $cartItems->sum(fn($item) => $item->variant->product->price * $item->quantity);
            \Log::debug('Total price calculated', ['total' => $total]);

            $discount = 0;
            $coupon = null;

            if (!empty($orderData['coupon_code'])) {
                \Log::debug('Processing coupon', ['coupon_code' => $orderData['coupon_code']]);

                $coupon = Coupon::where('code', $orderData['coupon_code'])
                    ->where('is_active', true)
                    ->where(function ($q) {
                        $q->whereNull('valid_from')->orWhere('valid_from', '<=', now());
                    })
                    ->where(function ($q) {
                        $q->whereNull('valid_until')->orWhere('valid_until', '>=', now());
                    })
                    ->first();

                if ($coupon) {
                    \Log::debug('Coupon found', ['coupon' => $coupon]);
                    if ($total >= $coupon->min_order_amount) {
                        $discount = $coupon->discount_type === 'percent'
                            ? intval($total * $coupon->discount_value / 100)
                            : $coupon->discount_value;
                        $discount = min($discount, $total);
                        \Log::debug('Discount applied', ['discount' => $discount]);
                    }
                } else {
                    \Log::debug('Coupon not valid');
                }
            }

            $order = Order::create([
                'user_id' => $user->id,
                'coupon_id' => $coupon?->id,
                'total_price' => $total,
                'discount_amount' => $discount,
                'payment_method' => $orderData['payment_method'],
                'shipping_address' => $orderData['shipping_address'],
                'status' => 'pending',
            ]);
            \Log::debug('Order created', ['order_id' => $order->id]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->variant->product_id,
                    'variant_id' => $item->variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->variant->product->price,
                ]);
                $item->variant->decrement('stock_quantity', $item->quantity);
                \Log::debug('stock_quantity decremented', ['variant_id' => $item->variant_id, 'quantity' => $item->quantity]);
            }

            Cart::where('user_id', $user->id)->delete();
            DB::commit();
            \Log::debug('Transaction committed');

            session()->forget('order_data');
            return view('user.order.complete', compact('order'));

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error during order processing', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->with('error', '注文処理中にエラーが発生しました。');
        }
    }

}
