<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class DashboardController extends Controller
{
    //
        /**
     * Display referrals listing.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {

        // $offerwall = '';
        // try {

        //     $response = Http::get("https://www.ayetstudios.com/offers/web_offerwall/15899?external_identifier=4082789");
        //     $offerwall = $response->body();

        // } catch (Exception $e) {
        //     Log::error("Shit happened");
        // }

        $offerwall_url = "https://www.ayetstudios.com/offers/web_offerwall/15899?external_identifier=4082789";
        
        return view('dashboard', ['offerwall_url' => $offerwall_url]);
    }
}
