<?php

namespace App\Livewire;

use Livewire\Component;

class UserTaskShowScreenshots extends Component
{
    public $user_task_id;
    public $show_screens = false;

    public function showProof()
    {
        $this->dispatch('show-proof', user_task_id: $this->user_task_id); 
    }

    public function render()
    {
        return view('livewire.user-task-show-screenshots');
    }
}
