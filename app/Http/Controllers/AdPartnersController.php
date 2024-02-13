<?php

namespace App\Http\Controllers;

use App\Enums\AdPartnersProvider;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Http\Request;

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

        echo json_encode(['status' => 'OK', 'provider' => $current_provider]);
    }
}
