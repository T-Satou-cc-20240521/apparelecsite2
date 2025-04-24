<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductColor;
use App\Models\ProductSize;



class ProductController extends Controller
{
    public function index()
    {
        return view('admin.product.index');
    }

    public function create()
    {
        $categories = Category::all();
        $product_colors = ProductColor::all();
        $product_sizes = ProductSize::all();
        return view('admin.product.create', compact('categories', 'product_colors', 'product_sizes'));
    }

    public function store(StoreProductRequest $request)
    {
        $product = new Product;
        $product->category_id = $request->input('category_id');
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $maxNumber = Product::max('display_number') ?? 0;
        $product->display_number = $maxNumber + 1;
        $product->save();
        return redirect()->route('admin.product.create');
    }

    public function list()
    {
        $products = Product::with(['variants.product_images'])->get();
        return view('admin.product.list', compact('products'));
    }


    public function detail($productId)
    {
        $product = Product::with(['category', 'variants'])->findOrFail($productId);
        $product_colors = ProductColor::all();
        $product_sizes = ProductSize::all();
        return view('admin.product.detail', compact('product', 'product_colors', 'product_sizes'));
    }


    public function edit($productid)
    {
        
    }

    public function update(Request $request, $productId)
    {
        $product = Product::find($productId);
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->is_active = $request->input('is_active');
        $product->save();
        return redirect()->route('admin.product.detail', ['id' => $product->id]);
    }

    public function delete($productId)
    {
        $product = Product::find($productId);
        $product->delete();

        $products = Product::orderBy('created_at')->get();

        $number = 1;
        foreach ($products as $item) {
            $item->display_number = $number++;
            $item->save();
        }

        return redirect()->route('admin.product.list');
    }
}
