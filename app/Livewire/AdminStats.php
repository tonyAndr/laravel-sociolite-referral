<?php

namespace App\Livewire;

use App\Models\Giveaway;
use App\Models\MasterTask;
use App\Models\Referral;
use App\Models\User;
use App\Models\Withdrawal;
use Livewire\Component;
use Livewire\Attributes\On; 

class AdminStats extends Component
{

    // stats interval
    public $date_interval = 'month'; // day, week, month
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

    public function mount() {
        $this->changeDate();
    }

    #[On('dateIntervalChange')] 
    public function changeDate($new_interval = 'month') {
        $this->date_interval = $new_interval;
        \date_default_timezone_set('Europe/Moscow');
        $now = now('Europe/Moscow');
        $new_date = false;

        switch($new_interval) {
            case 'day':
                $new_date = $now->subDay()->toDateTimeString();
                break;
            case 'week':
                $new_date = $now->subWeek()->toDateTimeString();
                break;
            case 'month':
                $new_date = $now->subMonth()->toDateTimeString();
                break;
        }

        $this->updateStats($new_date);
    }

    public function updateStats ($date_limit) {
        $this->withdrawals = $this->getWithdrawals($date_limit);
        $this->giveaways = $this->getGiveaways($date_limit);
        $this->task_orders = $this->getTasksOrdered($date_limit);
        $this->new_refs = $this->getReferrals($date_limit);
        $this->new_users = $this->getUsers($date_limit);
    }

    public function getWithdrawals($date_limit) {
        $wd = Withdrawal::selectRaw('count(*) as wd_count, SUM(amount) as total_sum')->where('status', 'approved')->where('updated_at', '>', $date_limit)->get();
        return $wd;
    }
    public function getGiveaways($date_limit) {
        $ga = Giveaway::selectRaw('count(*) as ga_count, SUM(reward) as total_sum')->where('status', 'finished')->where('updated_at', '>', $date_limit)->get();
        return $ga;
    }
    public function getTasksOrdered($date_limit) {
        $tasks = MasterTask::selectRaw('count(*) as tasks_count, SUM(price) as total_sum, SUM(user_reward) as total_reward')->where('status', 'finished')->where('updated_at', '>', $date_limit)->get();
        return $tasks;
    }
    public function getReferrals($date_limit) {
        $ref = Referral::selectRaw('count(*) as ref_count')->where('updated_at', '>', $date_limit)->get();
        return $ref;
    }
    public function getUsers($date_limit) {
        $users = User::selectRaw('count(*) as user_count')->where('updated_at', '>', $date_limit)->get();
        return $users;
    }

    public function render()
    {
        return view('livewire.admin-stats');
    }
}
