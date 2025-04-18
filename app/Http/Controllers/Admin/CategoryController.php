<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\Category;

class CategoryController extends Controller
{
    public function list()
    {
        $categories = Category::all();
        return view('admin.category.list',compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $tag = new Category;
        $tag->name = $request->input('name');
        $tag->save();
        return redirect()->route('admin.tag.create')->with('success', 'カテゴリーを登録しました。');
    }

    public function destroy(string $id)
    {
        $category = Category::find($categoryId);
        $category->delete();
        return redirect()->route('admin.category.list');
    }
}
