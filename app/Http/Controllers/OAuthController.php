<?php

namespace App\Http\Controllers;

use App\Enums\OAuthProvider;
use App\Events\ParticipantLoggedIn;
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
use App\Events\ParticipantRegistered;

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
            $user = $this->createOrUpdateUser($oAuthUser, $provider);

            Auth::login($user);

            $req_cookie = request()->cookie('referral');
            if ($req_cookie) {
                event(new ReferralDetected($req_cookie, $user));
            }

            $giveaway_cookie = request()->cookie('participant');
            if ($giveaway_cookie) {
                $user->giveaway = 1;
                $user->save();
                event(new ParticipantRegistered());
                return redirect()->route('giveaway');
            }

            $from_giveaway = request()->cookie('giveaway_login');
            if ($from_giveaway) {
                event(new ParticipantLoggedIn());
                return redirect()->route('giveaway.quiz', ['step' => 3]);
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

    private function createOrUpdateUser($oAuthUser, $provider) {
        
            $email = trim($oAuthUser->getEmail());

            // check oauth first
            $user = User::where('oauth_id', $oAuthUser->getId())->where('oauth_provider', $provider)->first();
            if (!$user) {
                // now check by email
                if ($email) {
                    $user = User::where('email', $email)->first();
                }
                if (!$user) {
                    $user = User::create([
                        'oauth_id' => $oAuthUser->getId(),
                        'oauth_provider' => $provider, 
                        'name' => $oAuthUser->getName(),
                        'email' => (null !== $email && !empty(trim($email))) ? $email : null,
                        'password' => Hash::make(Str::random(50)),
                        'avatar_url' => $oAuthUser->getAvatar(),
                        'oauth_token' => $oAuthUser->token,
                        'oauth_refresh_token' => $oAuthUser->refreshToken,
                    ]);
                } else {
                    $user->name = $oAuthUser->getName();
                    $user->oauth_id = $oAuthUser->getId(); 
                    $user->oauth_provider = $provider;
                    $user->avatar_url = $oAuthUser->getAvatar();
                    $user->oauth_token = $oAuthUser->token;
                    $user->oauth_refresh_token = $oAuthUser->refreshToken;
                    $user->save();
                }
            }

            if (!$user->email && $email) {
                $user->email = trim($email);
                $user->save();
            }
        return $user;
    }
}
