<?php

namespace App\Livewire;

use App\Models\MasterTask;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Gate;
use App\Livewire\Forms\TaskForm;

class EditMasterTask extends ModalComponent
{

    public TaskForm $form;
    // public MasterTask $task;

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
        $this->form->setTask($task);
    }

    public function review()
    {
        $this->form->update();
        $this->approve();
    }

    public function approve()
    {
        $this->form->task->update(['status' => 'active']);
        $this->closeModalWithEvents([
            TaskReviewAdminTable::class => 'taskModified',
        ]);
    }

    public function render()
    {
        return view('livewire.edit-master-task')->with([
            'task_id' => $this->form->task->id,
            'telegram_id' => $this->form->task->buyer_id,
            'price' => $this->form->task->price,
            'product' => $this->form->task->product->service,
        ]);;
    }
}
