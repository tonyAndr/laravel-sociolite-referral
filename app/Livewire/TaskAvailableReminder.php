<?php

namespace App\Livewire;

use App\Models\MasterTask;
use Livewire\Component;
use App\Models\User;
use App\Models\UserTask;

class TaskAvailableReminder extends Component
{
    public $user_id;
    public $is_participating = false;

    public function mount($user_id, $is_participating) {
        $this->user_id = intval($user_id);
        $this->is_participating = boolval($is_participating);
    }

    public function render()
    {

        $task_available = false;
        if ($this->is_participating) {
            $user = User::find($this->user_id);
            // get master tasks where active
            $master_tasks = MasterTask::where('status', 'active')->get();
            foreach ($master_tasks as $key => $mt) {
                # code...
                $user_has_the_task = UserTask::where('user_id', $user->id)->where('master_task_id', $mt->id)->whereNot('status', 'cancelled')->count();
                // if task has free slots
                $mt_taken_by_users = $mt->usertasks->where('status', 'active')->all();
                $has_free_slots = $mt->requested - ($mt->fullfilled + count($mt_taken_by_users)) > 0; 

                // if user doesnt have the task with same master_id then show the component
                if ($user_has_the_task <= 0 && $has_free_slots) {
                    $task_available = true;
                    
                }
            }
        }

        return view('livewire.task-available-reminder')->with('tasks_available', $task_available);
    }
}
