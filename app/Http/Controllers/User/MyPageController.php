<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class MyPageController extends Controller
{
    public function list()
    {
        $user = Auth::user();
        $orders = $user->orders()->orderBy('created_at', 'desc')->get();
        
        return view('user.mypage.list', compact('user', 'orders'));
    }
}

