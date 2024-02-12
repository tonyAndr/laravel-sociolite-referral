<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GiveawayController extends Controller
{
    //
        /**
     * Display referrals listing.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('giveaway');
    }

}
