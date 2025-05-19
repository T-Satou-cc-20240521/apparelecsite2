<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    // ログインフォーム表示
    public function showLoginForm() {
        return view('auth.login');
    }

    // ログイン処理
    public function login(LoginRequest $request) {
        $user_data = $request->only(['email', 'password']);

        Log::info('ログイン試行', ['email' => $user_data['email']]);

        // ログイン試行
        if (Auth::attempt($user_data)) {
            $request->session()->regenerate();

            $user = Auth::user();
            Log::info('ログイン成功', [
                'user_id' => $user->id,
                'is_admin' => $user->is_admin,
                'is_active' => $user->is_active,
            ]);

            if ((bool) $user->is_admin) {
                Log::info('管理者としてログイン');
                return redirect()->route('admin.top');
            } else {
                Log::info('一般ユーザーとしてログイン');
                return redirect()->route('user.top');
            }
        }

        Log::warning('ログイン失敗', ['email' => $user_data['email']]);

        return back()->withInput($request->only('email'))->withErrors([
            'login_error' => '入力された情報に誤りがあります。',
        ]);
    }

    // ログアウト処理
    public function logout() {
        Log::info('ログアウト', ['user_id' => Auth::id()]);
        Auth::logout();
        return redirect()->route('user.top');
    }
}