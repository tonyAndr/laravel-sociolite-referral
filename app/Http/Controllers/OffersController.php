<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class OffersController extends Controller
{
    //
        /**
     * Display referrals listing.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function ayetstudios(Request $request): View
    {
        $logo = "/images/offers/ayetstudios.png";
        $offerwall_url = "https://www.ayetstudios.com/offers/web_offerwall/15899?external_identifier=4082789";
        
        return view('offers.index', ['offerwall_url' => $offerwall_url, 'logo' => $logo]);
    }

    public function cpalead(Request $request): View
    {
        $user_id = $request->user()->id;
        $logo = "/images/offers/cpa_lead.png";
        $offerwall_url = "https://fastsvr.com/list/519960?subid=$user_id";
        
        return view('offers.index', ['offerwall_url' => $offerwall_url, 'logo' => $logo]);
    }
}
