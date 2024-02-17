<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class WithdrawalController extends Controller
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
        return view('withdrawal.index');
    }


    public function create(Request $request) {
        $user = $request->user();
        $balance = $user->robux;
        $to_withdraw = floatval($request->get('amount'));

        if ($balance < $to_withdraw) {
            echo json_encode([
                "result" => false,
                "msg" => "insufficient_balance"
            ]);
            return;
        }

        $withdrawals_history = Withdrawal::where('user_id', $user->id)->where('status', 'pending')->get();
        $ordered_sum = 0;
        foreach ($withdrawals_history as $w) {
            if ($w->status === 'pending') {
                $ordered_sum += $w->amount;
            }
        }

        if (($balance - $ordered_sum) < $to_withdraw) {
            echo json_encode([
                "result" => false,
                "msg" => "insufficient_balance"
            ]);
            return;
        }

        $withdrawal = new Withdrawal();
        $withdrawal->user_id = $user->id;
        $withdrawal->amount = $to_withdraw;
        $withdrawal->status = 'pending';
        $withdrawal->save();
    
        echo json_encode([
            "result" => true,
            "msg" => "order_placed"
        ]);
        return;
    }
}
