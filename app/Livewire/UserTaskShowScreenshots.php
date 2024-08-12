<?php

namespace App\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\User;
use App\Models\UserTask;

class UserTaskShowScreenshots extends Component
{
    public $user_task_id;
    public $show_screens = false;

    public function showProof()
    {
        $this->show_screens = !$this->show_screens;
    }

    public function render()
    {
        $user_task = UserTask::find(intval($this->user_task_id));
        $screenshot_urls = [];

        if ($this->show_screens) {
            if ($user_task->proof) {
                if (in_array($user_task->mastertask->proof_type, ['screenshot', 'screenshot_nickname'])) {

                    if (strpos($user_task->proof, ',') !== false ) {
                        $screenshot_urls = explode(',', $user_task->proof);
                    } else {
                        $screenshot_urls[] = $user_task->proof;
                    }
                }
            }
        }

        return view('livewire.user-task-show-screenshots')->with([
            'screenshots' => $screenshot_urls,
            'service_nickname' => $user_task->service_nickname
        ]);;
    }
}
