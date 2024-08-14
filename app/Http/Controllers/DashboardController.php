<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Models\MasterTask;
use App\Models\UserTask;

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

        $user = $request->user();
        $master_tasks = MasterTask::where('status', 'active')->get();
        $user_tasks = [];
        foreach ($master_tasks as $k => $mt) {
            $active_user_tasks = UserTask::where('master_task_id', $mt->id)->where('status', 'active')->whereNot('user_id', $user->id)->get();
            $in_work_count = count($active_user_tasks);
            $progress = $mt->fullfilled + $in_work_count;
            $user_already_has = UserTask::where('user_id', $user->id)->where('master_task_id', $mt->id)->first();
            if ($progress < $mt->requested || ($user_already_has && $user_already_has->status === 'active')) {
                // aligible to show to users
                if ($user_already_has) {
                    $mt->user_task_status = $user_already_has->status;
                }
                $user_tasks[] = $mt;
            } 
        }

        return view('dashboard', ['user_tasks' => $user_tasks]);
    }
}
