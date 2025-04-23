<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductColor;
use App\Models\ProductSize;

class VariantController extends Controller
{
    public function update(Request $request, Product $product)
    {
        foreach ($request->input('variants', []) as $variantData) {
            $variant = ProductVariant::find($variantData['id']);

            if ($variant && $variant->product_id === $product->id) {
                $variant->is_active = $variantData['is_active'] ?? 0;
                $variant->stock_quantity = $variantData['stock_quantity'] ?? 0;
                $variant->save();
            }
        }

        return redirect()->back()->with('success', '公開設定と在庫数を更新しました');
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'color_id' => 'required|exists:product_colors,id',
            'size_id' => 'required|exists:product_sizes,id',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'required|boolean',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('variants', 'public');
        }

        $variant = $product->variants()->create([
            'color_id' => $request->color_id,
            'size_id' => $request->size_id,
            'stock_quantity' => $request->stock_quantity,
            'is_active' => $request->is_active,
        ]);

        if ($path) {
            $variant->product_images()->create([
                'image_path' => $path,
                'priority' => 0,
            ]);
        }

        return redirect()->back()->with('success', 'バリエーションを追加しました');
    }

    public function delete(Product $product, ProductVariant $variant)
    {
        foreach ($variant->product_images as $image) {
            \Storage::disk('public')->delete($image->image_path);
        }

        $variant->delete();

        return redirect()->back()->with('success', 'バリエーションを削除しました');
    }
}


