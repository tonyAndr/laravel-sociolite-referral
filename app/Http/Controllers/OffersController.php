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
        $bg = "bg-white";
        $text_color = "text-black";
        $offerwall_url = "https://fastsvr.com/list/519960?subid=$user_id";
        
        return view('offers.index', ['offerwall_url' => $offerwall_url, 'logo' => $logo, 'bg' => $bg, 'text_color' => $text_color]);
    }
    public function mylead(Request $request): View
    {
        $user_id = $request->user()->id;
        $logo = "/images/offers/mylead_logo.png";
        $bg = "bg-slate-600";
        $text_color = "text-white";
        $offerwall_url = "https://mobile-rewards.pl/iframe/08df4560-cbb2-11ee-bae5-f3dc63b08ead?ml_sub1=$user_id";
        
        return view('offers.index', ['offerwall_url' => $offerwall_url, 'logo' => $logo, 'bg' => $bg, 'text_color' => $text_color]);
    }
    public function yandex_reward(Request $request): View
    {
        $user_id = $request->user()->id;
        $logo = "/images/offers/yandex_logo.png";
        $bg = "bg-amber-400";
        $text_color = "text-black";
        
        return view('tasks.yandex', ['logo' => $logo, 'bg' => $bg, 'text_color' => $text_color]);
    }
}
