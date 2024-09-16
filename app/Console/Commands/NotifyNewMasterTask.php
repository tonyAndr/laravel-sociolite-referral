<?php

namespace App\Console\Commands;

use App\Http\Controllers\MasterTaskController;
use Illuminate\Console\Command;

class NotifyNewMasterTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:new-task-notification';

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
        MasterTaskController::notifyChannelNewTask();
        $this->info('New tasks notification sent');
    }
}
