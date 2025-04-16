<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Banner;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function top()
    {
        $categories = Category::all();
        $banners = Banner::active()->get();
        return view('user.top', compact('categories', 'banners'));
    }
}
