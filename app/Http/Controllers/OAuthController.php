<?php
namespace App\Http\Controllers;
 
use App\Enums\OAuthProvider;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Http\Request;
 
class OAuthController extends Controller
{
    // ...

    public function redirect(OAuthProvider $provider): RedirectResponse
    {
        $resp = Socialite::driver($provider->driver())->redirect();
        return $resp;
    }
 
    public function callback(Request $request, OAuthProvider $provider): RedirectResponse
    {
        $oAuthUser = Socialite::driver($provider->driver())->user();

        $everything = $request->all();
 
        $user = User::updateOrCreate([
            'oauth_id' => $oAuthUser->getId(),
            'oauth_provider' => $provider,
        ], [
            'name' => $oAuthUser->getName(),
            'email' => $oAuthUser->getEmail(),
            'password' => Hash::make(Str::random(50)),
            'avatar_url' => $oAuthUser->getAvatar(),
            'oauth_token' => $oAuthUser->token,
            'oauth_refresh_token' => $oAuthUser->refreshToken,
        ]);
 
        Auth::login($user);

        $req_cookie = request()->cookie('referral');
        $referral = $request->referral($req_cookie);
        if ($referral) {
            $referral->complete();
        }
 
        return redirect()->route('dashboard');
    }

    
}