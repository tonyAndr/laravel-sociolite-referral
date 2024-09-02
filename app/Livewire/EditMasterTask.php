<?php

namespace App\Livewire;

use App\Http\Controllers\MasterTaskController;
use App\Models\MasterTask;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Gate;
use App\Livewire\Forms\TaskForm;
use App\Telegram\Commands\CreateTaskCommand;

class EditMasterTask extends ModalComponent
{

    public TaskForm $form;
    public $edit_action;

    /**
     * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
     */
    public static function modalMaxWidth(): string
    {
        return '5xl';
    }

    public function mount(MasterTask $task, $edit_action)
    {
        // Gate::authorize('update', $this->user);
        $this->form->setTask($task);
        $this->edit_action = $edit_action;
    }

    public function review()
    {
        $this->form->update();
        $this->approve();

        $this->closeModalWithEvents([
            TaskReviewAdminTable::class => 'taskModified',
            TaskHistoryAdminTable::class => 'taskModified',
        ]);
    }

    public function edit() 
    {
        $this->form->update();
        $this->closeModalWithEvents([
            TaskHistoryAdminTable::class => 'taskModified',
        ]);
    }

    public function approve()
    {
        $this->form->task->update(['status' => 'active']);
        // notify buyer
        CreateTaskCommand::handleApprove($this->form->task);
        // notify users
        MasterTaskController::notifyChannelNewTask($this->form->task);
    }

    public function render()
    {

        return view('livewire.edit-master-task')->with([
            'task_id' => $this->form->task->id,
            'telegram_id' => $this->form->task->buyer_id,
            'price' => $this->form->task->price,
            'product' => $this->form->task->product->service,
            'product_description' => $this->form->task->product->description,
            'edit_action' => $this->edit_action
        ]);;
    }
}
