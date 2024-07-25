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
        return view('giveaway.giveaway');
    }

    public function quiz(Request $request)
    {
        $step = intval($request->get('step'));
        switch ($step) {
            // case 1:
            // case 2:
            //     $countdown_time = 7;
            //     break;
            // case 3:
            //     $countdown_time = 100;
            //     break;
            // case 4:
            //     $countdown_time = 200;
            //     break;
            default:
                $countdown_time = 6;
                break;
        }
        
        if ($step) {
            if ($step < 50) {
                return view('giveaway.quiz_step', ['step' => $step, 'countdown_time' => $countdown_time]);
            } else {
                return view('auth.login');

            }
        }
        return view('giveaway.giveaway_quiz');
    }

}
