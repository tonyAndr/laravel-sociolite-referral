<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Giveaway;
use App\Events\ParticipantRegistered;

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

        // If logged-in user is gonna participate
        $user = $request->user();
        $giveaway_cookie = request()->cookie('participant');
        if (!is_null($user) && ($giveaway_cookie || $request->has('participant'))) {
            $user->giveaway = 1;
            $user->save();
            event(new ParticipantRegistered());
        }

        // Determine next giveaway time
        // We have 3 giveaways: 11:00, 15:00, 20:00
        // I need difference in seconds between now and next giveaway
        \date_default_timezone_set('Europe/Moscow'); // Set your timezone
        $lates_ga = Giveaway::where('status', 'active')->orderBy('id', 'desc')->first();
        // Current time
        $now = new \DateTime();

        // Target times today
        $ga_time = new \DateTime($lates_ga->finalization_date);

        // Calculate the difference
        $diff = $now->diff($ga_time);
        $seconds = ($diff->days * 24 * 60 * 60) + ($diff->h * 60 * 60) + ($diff->i * 60) + $diff->s;

        // Participants
        $participants = User::where('giveaway', 1)->get();
        $user_is_participating = false;
        if (!is_null($user) && $user->giveaway > 0) {
            $part_count = count($participants);
            if ($part_count > 1) {
                $chance_to_win = round(1/(count($participants)-$user->giveaway), 2);
            } else {
                $chance_to_win = 100;
            }
            $user_is_participating = true;
        } else {
            $chance_to_win = 0;
        }


        return view('giveaway.giveaway', ['countdown_time' => $seconds, 'participants' => $participants, 'reward'=> $lates_ga->reward, 'chance' => $chance_to_win, 'user_is_participating' => $user_is_participating]);
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
