<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('app:giveaway-handle')->cron('0 11,15,20 * * *')->timezone('Europe/Moscow');
        $schedule->command('app:expire-tasks')->cron('*/3 * * * *')->timezone('Europe/Moscow');
        $schedule->command('app:user-task-reminder')->cron('*/30 * * * *')->timezone('Europe/Moscow');
        $schedule->command('app:tg-parser')->cron('16 */2 * * *')->timezone('Europe/Moscow');
        $schedule->command('app:new-task-notification')->cron('30 13 * * *')->timezone('Europe/Moscow');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
