<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        $product = Product::find($request->product_id);
        $variant = ProductVariant::find($request->variant_id);

        if (!$product || !$product->is_active || $variant->stock_quantity <= 0) {
            return redirect()->route('user.cart.list')->with('error', 'この商品は購入できません。');
        }

        $cart = Cart::updateOrCreate(
            [
                'user_id' => $userId,
                'variant_id' => $request->variant_id,
            ],
            [
                'product_id' => $request->product_id,
                'quantity' => \DB::raw('quantity + ' . $request->quantity),
            ]
        );
        return redirect()->route('user.cart.list')->with('success', 'カートに追加しました！');
    }

    public function list()
    {
        $carts = Cart::where('user_id', Auth::id())
            ->with(['product', 'variant'])
            ->get()
            ->filter(function ($cart) {
                return $cart->product && $cart->product->is_active && $cart->variant && $cart->variant->stock_quantity > 0;
            });
        return view('user.cart.list', compact('carts'));
    }

    public function remove($id)
    {
        $cart = Cart::findOrFail($id);
        if ($cart->user_id !== Auth::id()) {
            return redirect()->route('user.cart.list')->with('error', 'この操作は許可されていません。');
        }
        $cart->delete();
        return redirect()->route('user.cart.list')->with('success', 'カートから削除しました。');
    }
}
