<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        return view('auth.register');
    }

    public function confirm(RegisterRequest $request)
    {
        $request->session()->put('form_data', $request->all());
        $validated = $request->validated();
        $request->session()->forget('errors');
        return view('auth.confirm', compact('validated'));
    }

   public function complete(Request $request) 
{
    $formData = $request->session()->get('form_data');
    if (!$formData) {
        return redirect()->route('auth.register')->withErrors('データが見つかりません。');
    }

    // デバッグログ出力（安全な開発環境のみで使用してください）
    Log::debug('登録処理', [
        'plain_password' => $formData['password'], // プレーンテキストか？
        'hashed_password' => Hash::make($formData['password']),
    ]);

    $user = User::create([
        'name'           => $formData['name'],
        'email'          => $formData['email'],
        'phone_number'   => $formData['phone_number'] ?? null,
        'password'       => Hash::make($formData['password']),
        'address'        => $formData['address'] ?? null,
        'is_active'      => true,
        'is_admin'       => false,
    ]);

    $request->session()->forget('form_data');
    return view('auth.complete');
}
}