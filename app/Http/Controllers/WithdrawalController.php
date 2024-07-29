<?php

namespace App\Http\Controllers;

use App\Events\WithdrawalApproved;
use App\Events\WithdrawalCancelled;
use App\Events\WithdrawalPlaced;
use App\Models\Withdrawal;
use App\Notifications\SendRobuxToUser;
use App\Notifications\WithdrawalRequested;
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
        $user = $request->user();
        $robux = $user->robux;

        $select_options = [];
        $option = 100;
        while ($robux >= 100) {
            $select_options[] = $option;
            $robux -= 100;
            
            if ($option >= 500) {
                break;
            }
            $option += 100;
        }
        return view('withdrawal.index', ['user' => $user, 'select_options' => $select_options]);
    }
    public function instruction(Request $request)
    {
        return view('withdrawal.instruction');
    }


    public function create(Request $request) {

        // $request->validate([
        //     'robux' => ['required', 'integer', 'min:20'],
        //     'gamepass' => ['required', 'string', 'url:http,https'],
        // ],[
        //     'robux' => 'Минимальная сумма вывода - 20 робуксов',
        //     'gamepass' => 'Ссылка не указана или неправильная',
        // ]);

        $user = $request->user();
        $balance = $user->robux;
        $to_withdraw = intval($request->get('amount'));

        if ($to_withdraw < 100) {
            echo json_encode([
                "result" => false,
                "msg" => "minimum_sum"
            ]);
            return;
        }

        if ($balance < $to_withdraw) {
            echo json_encode([
                "result" => false,
                "msg" => "insufficient_balance"
            ]);
            return;
        }
        // if (empty($gamepass) || !str_contains($gamepass, 'http') || !str_contains($gamepass, 'roblox.com/game-pass')) {
        //     echo json_encode([
        //         "result" => false,
        //         "msg" => "gamepass_error"
        //     ]);
        //     return;
        // }

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

        event(new WithdrawalPlaced($withdrawal));
        $user->notify(new WithdrawalRequested($withdrawal));
    
        echo json_encode([
            "result" => true,
            "msg" => "order_placed"
        ]);
        return;
    }

    public function approve(Request $request) {
        $withdrawal = Withdrawal::find($request->get('id'));
        $withdrawal->redeem_code = $request->get('redeem_code');
        $withdrawal->status = 'approved';
        $withdrawal->save();
        $comment = $request->get('comment');
        $user = $withdrawal->getUser();
        $user->robux = $user->robux - $withdrawal->amount;
        $user->save();
        // event(new WithdrawalApproved($withdrawal));
        $user->notify(new SendRobuxToUser($withdrawal));
        echo json_encode([
            "result" => true,
            "msg" => "order_approved"
        ]);
        return;
    }

    public function cancel(Request $request) {
        $withdrawal = Withdrawal::find($request->get('id'));
        $withdrawal->status = 'cancelled';
        $withdrawal->comment = $request->get('reason');
        $withdrawal->save();

        $user = $withdrawal->getUser();

        //!! todo: notify user? 
        if ($user->email) {
            $reason = $request->get('reason');
            event(new WithdrawalCancelled($reason, $user->email));
        }

        echo json_encode([
            "result" => true,
            "msg" => "order_cancelled"
        ]);
        return;
    }
}
