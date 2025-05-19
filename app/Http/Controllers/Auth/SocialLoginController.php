<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\SocialAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialLoginController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $socialUser = Socialite::driver($provider)->user();
        $user = Auth::user();

        $user->socialAccounts()->updateOrCreate(
            ['provider' => $provider],
            [
                'provider_user_id' => $socialUser->getId(),
                'provider_token' => $socialUser->token,
                'provider_refresh_token' => $socialUser->refreshToken ?? null,
            ]
        );

        return redirect()->route('mypage.account')->with('success', "{$provider}と連携しました");
    }

    public function detach($provider)
    {
        Auth::user()->socialAccounts()->where('provider', $provider)->delete();

        return redirect()->route('mypage.account')->with('success', "{$provider}の連携を解除しました");
    }
}
