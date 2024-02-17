<?php

namespace App\Http\Controllers;

use App\Enums\AdPartnersProvider;
use App\Models\User;
use Exception;
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
            list($user_id, $robux) = $this->cpalead($request_params);
        }

        if ($current_provider === 'mylead') {
            list($user_id, $robux) = $this->mylead($request_params);
        }
        if ($current_provider === 'yandex') {
            $user = $request->user();
            $robux = 0.1;
        }

        try {
            $user = $user ?? User::find($user_id);
            if (!$user) {
                throw new Exception("User not found");
            }
            $user->addRobux($robux);
            Log::info("Robux rewarded to user " . $user->id);
        } catch (Exception $e) {
            Log::info("User not found ".$e->getMessage());
        }


        echo json_encode(['status' => 'OK', 'provider' => $current_provider]);
    }

    private function cpalead ($request_params) {
        // !! TODO: add security check
        $user_id = intval($request_params['subid']) ?? null;
        $robux = floatval($request_params['payout']) ? floatval($request_params['payout'])*100/2 : 0;
        return [$user_id, $robux];
    }
    private function mylead ($request_params) {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $protocol = 'https';
        $url = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $hash = hash_hmac('sha256', $url, "kcQyDJ7FOB85mEVi5B34h8AINXlB4BrXbv25iZNgREZIdiLqbrBDcHjftRjq");
        if ($_SERVER['HTTP_X_MYLEAD_SECURITY_HASH'] === $hash) {
            // successful verification. It is safe to process the postback
            if ($request_params['status'] === 'approved') {
                $user_id = intval($request_params['ml_sub1']) ?? null;
                $robux = floatval($request_params['payout']) ?? 0;
                return [$user_id, $robux];
            }
        }
        return [null, 0];
    }

}
