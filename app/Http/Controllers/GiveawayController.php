<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Giveaway;
use App\Events\ParticipantRegistered;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        $is_member = false;

        $subscription_needed = false;
        $ga_reward = 0;
        $diff_seconds = 0;
        $participants = [];
        $chance_to_win = 0;
        $user_is_participating = false;
        $prev_won = false;

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
        if (!is_null($lates_ga)) {

            // Current time
            $now = new \DateTime();

            // Target times today
            $ga_time = new \DateTime($lates_ga->finalization_date);

            // Calculate the difference
            $diff = $now->diff($ga_time);
            $diff_seconds = ($diff->days * 24 * 60 * 60) + ($diff->h * 60 * 60) + ($diff->i * 60) + $diff->s;

            // Participants
            $participants = User::where('giveaway', 1)->get();
            if (!is_null($user) && $user->giveaway > 0) {
                $part_count = count($participants);
                if ($part_count > 0) {
                    $chance_to_win = round(1 / ($part_count), 2) * 100;
                }
                $user_is_participating = true;
            } else {
                $chance_to_win = 0;
            }

            // if user won the previos giveaway
            $lates_finished_ga = Giveaway::where('status', 'finished')->orderBy('id', 'desc')->first();
            if (!is_null($lates_finished_ga)) {
                if (!is_null($user) && $user->id === $lates_finished_ga->winner_id) {
                    $prev_won = true;
                }
            }
            $ga_reward = $lates_ga->reward;
        }

        // check subscription
        // $is_subbed = $this->check_subscription($user->oauth_id, env('TELEGRAM_LUCHBUX_CHANNEL_LIVE_ID'));
        // $subscription_needed = !$is_subbed['result'];

        return view('giveaway.giveaway', ['countdown_time' => $diff_seconds, 'participants' => $participants, 'reward' => $ga_reward, 'chance' => $chance_to_win, 'user_is_participating' => $user_is_participating, 'you_won' => $prev_won]);
    }

    public function quiz(Request $request)
    {
        $step = intval($request->get('step'));
        switch ($step) {
                // case 1:
                // case 2:
                //     $countdown_time = 7;
                //     break;
                // case 4:
                //     $countdown_time = 200;
                //     break;
            default:
                $countdown_time = 30;
                break;
        }

        if ($step) {
            if ($step < 50) {
                return view('giveaway.quiz_step', ['step' => $step, 'countdown_time' => $countdown_time]);
            } else {
                return view('auth.login');
            }
        } else {
            return redirect()->route('giveaway');
        }
        return view('giveaway.giveaway');
    }

    // http request / user has to be subbed to the channel
    // public function is_subscribed(Request $request)
    // {
    //     $user = $request->user();
    //     $channel_id = $request->get('channel_id');

    //     if (is_null($user)) {
    //         echo json_encode([
    //             "result" => false,
    //             "reason" => 'user_not_found'
    //         ]);
    //         return;
    //     }

    //     $response = $this->check_subscription($user->oauth_id, $channel_id);

    //     echo json_encode($response);
    //     return;
    // }

    // local use
    public static function checkSubscription($user_tg_id, $channel_id)
    {
        $response = Http::post('https://api.telegram.org/bot' . env('TELEGRAM_LOGIN_API_TOKEN') . '/getChatMember', [
            'chat_id' => $channel_id,
            'user_id' => $user_tg_id,
        ]);
        $body = json_decode($response->body());
        if ($body->ok) {
            $status = $body->result->status;
            if ($status === 'member' || $status === 'administrator' || $status === 'creator') {
                return [
                    "result" => true,
                    "reason" => ''
                ];
            } else {
                return [
                    "result" => false,
                    "reason" => 'not_subbed'
                ];
            }
        }

        return [
            "result" => false,
            "reason" => 'unknown'
        ];
    }
}
