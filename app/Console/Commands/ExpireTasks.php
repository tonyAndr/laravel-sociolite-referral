<?php

namespace App\Console\Commands;

use App\Http\Controllers\ReferralController;
use Illuminate\Console\Command;
use App\Models\Giveaway;
use App\Models\User;
use App\Notifications\NotifyGiveawayWinner;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ChannelPostWinnerDetails;
use Illuminate\Support\Facades\App;
use App\Models\UserTask;
use App\Notifications\UserTaskExpired;

class ExpireTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expire-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get all active user tasks
        $now = now('Europe/Moscow')->toDateTimeString();
        $expired_user_tasks = UserTask::where('status', 'active')->where('expires_at', '<', $now)->get();
        foreach ($expired_user_tasks as $key => $expired_task) {
            # code...
            $expired_task->status = 'cancelled';
            $expired_task->save();

            $mastertask = $expired_task->mastertask;

            // notify users

            $user = User::find($expired_task->user_id);
            if ($user) {
                $user->notify(new UserTaskExpired($mastertask));
            }
        }

        $this->info('Tasks expiration checked');
    }
}
