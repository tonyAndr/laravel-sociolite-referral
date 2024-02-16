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
use App\Events\ReferralDetected;
use Exception;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Laravel\Socialite\Two\InvalidStateException;
use Illuminate\Support\Facades\Log;

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
        $everything = $request->all();
        try {

            $oAuthUser = Socialite::driver($provider->driver())->user();
            $email = $oAuthUser->getEmail();
            $user = User::updateOrCreate([
                'oauth_id' => $oAuthUser->getId(),
                'oauth_provider' => $provider,
            ], [
                'name' => $oAuthUser->getName(),
                'email' => (null !== $email && !empty(trim($email))) ? $email : null,
                'password' => Hash::make(Str::random(50)),
                'avatar_url' => $oAuthUser->getAvatar(),
                'oauth_token' => $oAuthUser->token,
                'oauth_refresh_token' => $oAuthUser->refreshToken,
            ]);

            Auth::login($user);

            $req_cookie = request()->cookie('referral');
            if ($req_cookie) {
                event(new ReferralDetected($req_cookie, $user));
            }
        } catch (InvalidStateException $e) {
            Log::error("LOGIN ERROR: " . $e->getMessage());
            Log::error("REQUEST DATA: " . var_export($everything, true));
        } catch (Exception $e) {
            Log::error("LOGIN ERROR: " . $e->getMessage());
            Log::error("REQUEST DATA: " . var_export($everything, true));
        }

        return redirect()->route('dashboard');
    }
}
