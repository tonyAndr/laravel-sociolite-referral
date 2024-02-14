<?php

namespace App\Http\Controllers;

use App\Enums\AdPartnersProvider;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdPartnersController extends Controller
{
    // ...

    // public function redirect(OAuthProvider $provider): RedirectResponse
    // {
    //     $resp = Socialite::driver($provider->driver())->redirect();
    //     return $resp;
    // }

    public function callback(Request $request, AdPartnersProvider $provider)
    {
        $current_provider = $provider->driver();
        $request_params  = $request->all();
        Log::info("Hit the callback URL $current_provider: " . var_export($request_params, true));

        if ($current_provider === 'cpalead') {

            $user_id = intval($request_params['subid']);
            $user = User::find($user_id);
            $robux = floatval($request_params['payout']);
            $user->addRobux($robux);

            Log::info("Robux rewarded to user $user_id");
        }

        echo json_encode(['status' => 'OK', 'provider' => $current_provider]);
    }
}
