<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;

class VariantController extends Controller
{
    public function update(Request $request, Product $product)
    {
        foreach ($request->input('variants', []) as $variantData) {
            $variant = ProductVariant::find($variantData['id']);
            if ($variant && $variant->product_id === $product->id) {
                $variant->is_active = $variantData['is_active'];
                $variant->save();
            }
        }

        return redirect()->back()->with('success', '公開設定を更新しました');
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'color' => 'required|string|max:50',
            'size' => 'required|string|max:50',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'required|boolean',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('variants', 'public');
        }

        $product->variants()->create([
            'color' => $request->color,
            'size' => $request->size,
            'stock_quantity' => $request->stock_quantity,
            'image_path' => $path,
            'is_active' => $request->is_active,
        ]);

        return redirect()->back()->with('success', 'バリエーションを追加しました');
    }

    public function delete($productId, $variantId)
    {
        $variant = ProductVariant::findOrFail($variantId);
        $variant->delete();
        return redirect()->back()->with('success', 'バリエーションを削除しました');
    }
}

