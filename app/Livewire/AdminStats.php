<?php

namespace App\Livewire;

use App\Models\Giveaway;
use App\Models\MasterTask;
use App\Models\Referral;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\Attributes\On; 

class AdminStats extends Component
{

    // stats interval
    // withdrawals 
    public $withdrawals;
    // giveaways 
    public $giveaways;
    // users of site, users of bot
    public $app_users;
    public $bot_users;
    // tasks ordered, sum
    public $task_orders;
    public $new_refs;
    public $new_users;

    public $user_task_id;

    public $interval_start;
    Public $interval_end;

    public function mount() {
        $this->changeDate();
    }
    

    #[On('dateIntervalChange')] 
    public function changeDate($start = NULL, $end = NULL) {
        \date_default_timezone_set('Europe/Moscow');

        // fallbacks
        if ($end === NULL) {
            $this->interval_end = now('Europe/Moscow');
        } else {
            $this->interval_end = Carbon::createFromTimestampMs($end, 'Europe/Moscow');
        }
        if ($start === NULL) {
            $this->interval_start = now('Europe/Moscow')->subMonth();
        } else {
            $this->interval_start = Carbon::createFromTimestampMs($start, 'Europe/Moscow');
        }

        // switch($new_interval) {
        //     case 'day':
        //         $new_date = $now->subDay()->toDateTimeString();
        //         break;
        //     case 'week':
        //         $new_date = $now->subWeek()->toDateTimeString();
        //         break;
        //     case 'month':
        //         $new_date = $now->subMonth()->toDateTimeString();
        //         break;
        // }

        $this->updateStats();
    }

    public function updateStats () {
        $this->withdrawals = $this->getWithdrawals();
        $this->giveaways = $this->getGiveaways();
        $this->task_orders = $this->getTasksOrdered();
        $this->new_refs = $this->getReferrals();
        $this->new_users = $this->getUsers();
    }

    public function getWithdrawals() {
        $wd = Withdrawal::selectRaw('count(*) as wd_count, SUM(amount) as total_sum')->where('status', 'approved')->whereBetween('updated_at', [$this->interval_start, $this->interval_end])->get();
        return $wd;
    }
    public function getGiveaways() {
        $ga = Giveaway::selectRaw('count(*) as ga_count, SUM(reward) as total_sum')->where('status', 'finished')->where('updated_at', '>', $this->interval_start->toDateTimeString())->where('updated_at', '<=', $this->interval_end->toDateTimeString())->get();
        return $ga;
    }
    public function getTasksOrdered() {
        $tasks = MasterTask::selectRaw('count(*) as tasks_count, SUM(price) as total_sum, SUM(user_reward) as total_reward')->where('status', 'finished')->where('updated_at', '>', $this->interval_start->toDateTimeString())->where('updated_at', '<=', $this->interval_end->toDateTimeString())->get();
        return $tasks;
    }
    public function getReferrals() {
        $ref = Referral::selectRaw('count(*) as ref_count')->where('updated_at', '>', $this->interval_start->toDateTimeString())->where('updated_at', '<=', $this->interval_end->toDateTimeString())->get();
        return $ref;
    }
    public function getUsers() {
        $users = User::selectRaw('count(*) as user_count')->whereBetween('updated_at', [$this->interval_start, $this->interval_end])->get();
        return $users;
    }

    public function render()
    {
        return view('livewire.admin-stats');
    }
}
