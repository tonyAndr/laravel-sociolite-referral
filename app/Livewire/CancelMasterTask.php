<?php

namespace App\Livewire;

use App\Models\MasterTask;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Gate;
use App\Livewire\Forms\TaskForm;
use Longman\TelegramBot\Commands\UserCommands\CreateTaskCommand;

class CancelMasterTask extends ModalComponent
{

    public MasterTask $task;
    public $reason;

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

    public function cancel()
    {
        $this->task->status = 'cancelled';
        $this->task->reason = $this->reason;
        $this->task->save();
        $this->task->refresh();
        CreateTaskCommand::handleRefund($this->task);
        $this->closeModalWithEvents([
            TaskReviewAdminTable::class => 'taskModified',
            TaskHistoryAdminTable::class => 'taskModified',
        ]);
    }

    public function render()
    {
        return view('livewire.cancel-master-task')->with([
            'task_id' => $this->task->id,
            'telegram_id' => $this->task->buyer_id,
            'price' => $this->task->price,
            'product' => $this->task->product->service,
        ]);;
    }
}
