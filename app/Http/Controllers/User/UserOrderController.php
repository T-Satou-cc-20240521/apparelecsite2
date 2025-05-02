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

        return view('user.order.form', compact('user', 'cartItems'));
    }

    public function confirm(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'address_option' => 'required|in:saved,new',
            'shipping_address' => 'nullable|required_if:address_option,new|string|max:255',
            'payment_method' => 'required|in:credit,e_money,bank_transfer',
            'coupon_code' => 'nullable|string',
        ]);

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

        $PaymentMethod = $request->payment_method;
        
        $paymentMethodLabel = $paymentMethodLabels[$PaymentMethod];


        return view('user.order.confirm', compact(
            'user',
            'cartItems',
            'shippingAddress',
            'coupon',
            'discount',
            'total',
            'paymentMethodLabel'
        ));
    }

    public function complete()
    {
        $user = Auth::user();
        $orderData = session('order_data');

        if (!$orderData) {
            return redirect()->route('user.order.form')->with('error', '注文情報が見つかりません。');
        }

        $cartItems = Cart::with('variant')->where('user_id', $user->id)->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart.list')->with('error', 'カートが空です。');
        }

        DB::beginTransaction();
        try {
            $total = $cartItems->sum(fn($item) => $item->variant->product->price * $item->quantity);
            $discount = 0;
            $coupon = null;

            if (!empty($orderData['coupon_code'])) {
                $coupon = Coupon::where('code', $orderData['coupon_code'])->first();
                if ($coupon && $coupon->is_active && $total >= $coupon->min_order_amount) {
                    $discount = $coupon->discount_type === 'percent'
                        ? intval($total * $coupon->discount_value / 100)
                        : $coupon->discount_value;
                    $discount = min($discount, $total);
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

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->variant->product_id,
                    'variant_id' => $item->variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->variant->price,
                ]);
                $item->variant->decrement('stock', $item->quantity);
            }

            Cart::where('user_id', $user->id)->delete();
            DB::commit();
            session()->forget('order_data');

            return view('user.order.complete', compact('order'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', '注文処理中にエラーが発生しました。');
        }
    }
}
