<x-modal-wire>
    <x-slot name="title">
        <h3>Прогресс выполнения</h3>
    </x-slot>

    <x-slot name="content">
        <div class="flex flex-row gap-4">
            <div class="flex flex-col p-4">
                @foreach ($usertasks as $ut)
                    <div wire:key="{{$ut->id}}">
                        User ID: {{$ut->user_id}} | Выполнено: {{$ut->updated_at}}
                        <livewire:user-task-show-screenshots wire:key="{{$ut->id}}" user_task_id="{{$ut->id}}"/>
                    </div>
                @endforeach
            </div>
            <div class="border-1 border-green-300 rounded-md p-4">
                <div wire:loading> 
                    Ищу пруфы...
                </div>
                @if($service_nickname) 
                    Nick: <strong>{{$service_nickname}}</strong>
                @endif
                @if(count($screenshot_urls)) 
                    @foreach ($screenshot_urls as $k => $scr)
                        <p wire:key="{{$k}}">
                            <img class="max-w-full" src="{{Storage::url($scr)}}" />
                        </p>
                    @endforeach
                @endif
            </div>
        </div>

    </x-slot>

    <x-slot name="buttons">
        <button class="btn btn-success" wire:click="$dispatch('closeModal')">Закрыть</button>
    </x-slot>
</x-modal>