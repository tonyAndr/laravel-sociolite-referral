<x-modal-wire>
    <x-slot name="title">
        <h3>Прогресс выполнения</h3>
    </x-slot>

    <x-slot name="content">
        <div class="flex flex-col">
            @foreach ($usertasks as $ut)
                <div wire:key="{{$ut->id}}">
                    User ID: {{$ut->user_id}} | Выполнено: {{$ut->updated_at}}
                    <livewire:user-task-show-screenshots user_task_id="{{$ut->id}}"/>
                </div>
            @endforeach
        </div>

    </x-slot>

    <x-slot name="buttons">
        <button class="btn btn-success" wire:click="$dispatch('closeModal')">Закрыть</button>
    </x-slot>
</x-modal>