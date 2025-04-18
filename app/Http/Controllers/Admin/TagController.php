<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTagRequest;
use App\Models\Tag;

class TagController extends Controller
{
    public function list()
    {
        $tags = Tag::all();
        return view('admin.tag.list',compact('tags'));
    }

    public function create()
    {
        return view('admin.tag.create');
    }

    public function store(StoreTagRequest $request)
    {
        $tag = new Tag;
        $tag->name = $request->input('name');
        $tag->save();
        return redirect()->route('admin.tag.create')->with('success', 'タグを登録しました。');
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
