<?php

namespace App\Livewire;

use App\Http\Controllers\MasterTaskController;
use App\Models\MasterTask;
use App\Models\UserTask;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Gate;
use App\Telegram\Commands\CreateTaskCommand;
use Livewire\Attributes\On;

class ViewProgressMasterTask extends ModalComponent
{

    public MasterTask $task;
    public $screenshot_urls = [];
    public $service_nickname = false;

    /**
     * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
     */
    public static function modalMaxWidth(): string
    {
        return '5xl';
    }

    public function mount(MasterTask $task)
    {
        // Gate::authorize('update', $this->user);
        $this->task = $task;
    }
    
    #[On('refresh-task-progress-component')] 
    public function updateComponent()
    {
    }

    #[On('show-proof')] 
    public function showProof($user_task_id) {
        $user_task = UserTask::find(intval($user_task_id));
        $screenshot_urls = [];
        $service_nickname = false;

        if ($user_task->proof) {
            if (in_array($user_task->mastertask->proof_type, ['screenshot', 'screenshot_nickname'])) {

                if (strpos($user_task->proof, ',') !== false ) {
                    $screenshot_urls = explode(',', $user_task->proof);
                } else {
                    $screenshot_urls[] = $user_task->proof;
                }

                if ($user_task->service_nickname) {
                    $service_nickname = $user_task->service_nickname;
                }
            }
        }
        $this->screenshot_urls = $screenshot_urls;
        $this->service_nickname = $service_nickname;
    }

    public function render()
    {

        return view('livewire.view-progress-master-task')->with([
            'usertasks' => $this->task->usertasks->where('status', 'finished')->all(),
            'screenshot_urls' => $this->screenshot_urls,
            'service_nickname' => $this->service_nickname
        ]);;
    }
}
