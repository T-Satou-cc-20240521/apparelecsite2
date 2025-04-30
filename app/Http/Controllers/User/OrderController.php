<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function form()
    {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('variant')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart.list')->with('error', 'カートが空です。');
        }
        return view('user.order.form', [
            'cartItems' => $cartItems,
            'user' => $user,
        ]);
    }
    public function confirm(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'address_option' => 'required|in:saved,new',
            'shipping_address' => 'nullable|required_if:address_option,new|string|max:255',
            'payment_method' => 'required|in:credit,e_money,bank_transfer',
            'coupon_code' => 'nullable|string',
        ]);
        $addressOption = $request->input('address_option');
        $shippingAddress = $addressOption === 'new'
            ? $request->input('shipping_address')
            : $user->shipping_address;
        $cartItems = Cart::where('user_id', $user->id)->with('variant.product')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart.list')->with('error', 'カートが空です');
        }
        $total = $cartItems->sum(function ($item) {
            return $item->variant->price * $item->quantity;
        });
        $coupon = null;
        $discount = 0;
        if ($request->filled('coupon_code')) {
            $coupon = Coupon::where('code', $request->coupon_code)
                ->where('is_active', true)
                ->where(function ($query) {
                    $query->whereNull('valid_from')->orWhere('valid_from', '<=', now());
                })
                ->where(function ($query) {
                    $query->whereNull('valid_until')->orWhere('valid_until', '>=', now());
                })
                ->first();
            if ($coupon && $total >= $coupon->min_order_amount) {
                $discount = $coupon->discount_type === 'percent'
                    ? intval($total * ($coupon->discount_value / 100))
                    : $coupon->discount_value;
                $discount = min($discount, $total);
            } else {
                $coupon = null;
            }
        }
        return view('user.order.confirm', [
            'cartItems' => $cartItems,
            'total' => $total,
            'discount' => $discount,
            'finalTotal' => $total - $discount,
            'shippingAddress' => $shippingAddress,
            'paymentMethod' => $request->payment_method,
            'coupon' => $coupon,
            'request' => $request,
        ]);
    }
    public function complete()
    {
        $user = Auth::user();
        $orderData = session('order_data');
        if (!$orderData) {
            return redirect()->route('user.order.form')->with('error', '注文情報が見つかりません。');
        }
        $cartItems = Cart::where('user_id', $user->id)->with('variant')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart.list')->with('error', 'カートが空です。');
        }
        DB::beginTransaction();
        try {
            $total = $cartItems->sum(fn($item) => $item->variant->price * $item->quantity);
            $discount = 0;
            $coupon = null;
            if (!empty($orderData['coupon_code'])) {
                $coupon = Coupon::where('code', $orderData['coupon_code'])
                    ->where('is_active', true)
                    ->first();
                if ($coupon && $total >= $coupon->min_order_amount) {
                    $discount = $coupon->discount_type === 'percent'
                        ? intval($total * ($coupon->discount_value / 100))
                        : $coupon->discount_value;
                    $discount = min($discount, $total);
                }
            }
            $order = Order::create([
                'user_id' => $user->id,
                'coupon_id' => $coupon?->id,
                'total_price' => $total,
                'discount_amount' => $discount,
                'status' => 'pending',
                'payment_method' => $orderData['payment_method'],
                'shipping_address' => $orderData['shipping_address'],
            ]);
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->variant->price,
                ]);
                $variant = $item->variant;
                $variant->stock = max(0, $variant->stock - $item->quantity);
                $variant->save();
            }
            Cart::where('user_id', $user->id)->delete();
            DB::commit();
            session()->forget('order_data');
            return view('user.order.complete', ['order' => $order]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', '注文処理中にエラーが発生しました：' . $e->getMessage());
        }
    }
}
