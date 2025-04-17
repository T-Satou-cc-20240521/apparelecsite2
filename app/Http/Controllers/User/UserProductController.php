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
        $query = Product::query();

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
}

