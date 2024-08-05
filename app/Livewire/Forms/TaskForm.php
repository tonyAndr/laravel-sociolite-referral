<?php
 
namespace App\Livewire\Forms;

use App\Models\MasterTask;
use Livewire\Attributes\Validate;
use Livewire\Form;
 
class TaskForm extends Form
{
    public ?MasterTask $task;
 
    // #[Validate('required|min:5')]
    // public $title = '';
 
    // #[Validate('required|min:5')]
    // public $content = '';

    public $requested;
    public $title;
    public $description;
    public $ref_url;
    public $proof_type;
    public $user_reward;

 
    public function setTask(MasterTask $task)
    {
        $this->task = $task;
        $this->requested = $task->requested;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->ref_url = $task->ref_url;
        $this->proof_type = $task->proof_type;
        $this->user_reward = $task->user_reward;
 
    }
 
    public function update()
    {
        // $this->validate();
 
        $this->task->update(
            $this->only([
                'requested',
                'title', 
                'description',
                'ref_url',
                'proof_type',
                'user_reward'
                ])
        );
    }
}