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
use App\Notifications\UserTaskRemind;

class UserTaskReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user-task-reminder';

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
        $active_user_tasks = UserTask::where('status', 'active')->get();

        foreach ($active_user_tasks as $key => $task) {
            $mastertask = $task->mastertask;

            // notify users

            $user = User::find($task->user_id);
            if ($user) {
                try {
                    $user->notify(new UserTaskRemind($mastertask));
                    $this->info('user #'.$task->user_id.' was notified');
                } catch (\NotificationChannels\Telegram\Exceptions\CouldNotSendNotification $exception) {
                    $this->info('user #'.$task->user_id.' blocked the bot');
                }
            }
        }

        $this->info('Tasks reminded');
    }
}
