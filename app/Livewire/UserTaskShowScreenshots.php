<?php

namespace App\Livewire;

use App\Http\Controllers\UserTaskController;
use Livewire\Component;

class UserTaskShowScreenshots extends Component
{
    public $user_task_id;

    public function showProof()
    {
        $this->dispatch('show-proof', user_task_id: $this->user_task_id); 
    }


    
    public function reject() 
    {
        UserTaskController::reject($this->user_task_id);
        $this->dispatch('refresh-task-progress-component');
    }

    public function render()
    {
        return view('livewire.user-task-show-screenshots');
    }
}
