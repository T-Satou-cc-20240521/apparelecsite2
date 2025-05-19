<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class FavoriteController extends Controller
{
    public function list()
    {
        $favorites = Auth::user()->favorites()->with('product')->get();
        return view('user.favorite.list', compact('favorites'));
    }

    public function toggle(Request $request)
    {
        Log::debug('お気に入りトグルリクエスト', [
        'user_id' => Auth::id(),
        'product_id' => $request->input('product_id'),
        ]);

        $user = Auth::user();
        $productId = $request->input('product_id');

        $favorite = $user->favorites()->where('product_id', $productId)->first();

        if ($favorite) {
            $favorite->delete();
            $status = 'removed';
        } else {
            $user->favorites()->create(['product_id' => $productId]);
            $status = 'added';
        }

        return response()->json(['status' => $status]);
    }
}
