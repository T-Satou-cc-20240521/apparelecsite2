<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class UserProductController extends Controller
{
    public function list(Request $request)
    {
        $query = Product::query()
        ->where('is_active', 1)
        ->whereHas('variants', function ($q) {
            $q->where('is_active', 1)->where('stock_quantity', '>', 0);
        });

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        if ($request->filled('query')) {
            $query->where('name', 'like', '%' . $request->input('query') . '%');
        }

        $products = $query->get();
        $categories = Category::all();

        return view('user.product.list', compact('products', 'categories'));
    }

    public function detail($productId)
    {
        $product = Product::with([
            'variants.product_color',
            'variants.product_size',
            'variants.product_images'
        ])->findOrFail($productId);

        $colorOrder = ['ホワイト', 'ブラック', 'グレー', 'レッド', 'ブルー', 'ネイビー', 'グリーン', 'イエロー', 'ピンク', 'ベージュ', 'ブラウン', 'パープル', 'オレンジ', 'カーキ', 'ライトグレー'];

        $colors = $product->variants
            ->unique('color_id')
            ->sortBy(function($variant) use ($colorOrder) {
                return array_search($variant->product_color->name, $colorOrder);
            });

        $sizeOrder = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];

        $sizes = $product->variants
            ->sortBy(function($variant) use ($sizeOrder) {
                return array_search($variant->product_size->name, $sizeOrder);
            });

        return view('user.product.detail', compact('product', 'colors', 'sizes'));
    }
}

