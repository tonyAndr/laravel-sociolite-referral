<?php

namespace App\Livewire;

use App\Http\Controllers\MasterTaskController;
use App\Models\MasterTask;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Gate;
use Longman\TelegramBot\Commands\UserCommands\CreateTaskCommand;

class ViewProgressMasterTask extends ModalComponent
{

    public MasterTask $task;
    public $showProofs;

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
        $this->showProofs = [];
    }


    public function showProof($user_task_id) {
        $this->showProofs[] = $user_task_id;
    }

    public function render()
    {

        return view('livewire.view-progress-master-task')->with([
            'usertasks' => $this->task->usertasks->where('status', 'finished')->all(),
            'showProofIds' => $this->showProofs
        ]);;
    }
}
