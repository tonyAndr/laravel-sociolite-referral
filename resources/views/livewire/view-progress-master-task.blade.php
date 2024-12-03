<x-modal-wire>
    <x-slot name="title">
        <h3>Прогресс выполнения</h3>
    </x-slot>

    <x-slot name="content">
        <div class="flex flex-row gap-4">
            <div class="flex flex-row flex-wrap gap-3 p-4">
                @foreach ($usertasks as $ut)
                    <div wire:key="{{$ut->id}}" class="relative">
                        <div class="card bg-base-200 w-72 shadow-xl">
                            <div class="card-body">
                                <div>User ID: {{$ut->user_id}}<br>Выполнено: {{$ut->updated_at}}</div>
                                @if($ut->service_nickname)
                                    <div>Ник в сервисе: {{$ut->service_nickname}}</div>
                                @endif
                                Пруф:
                            </div>
                            @if ($ut->mastertask->proof_type === 'text') 
                            <p class="px-4"><a href="{{$ut->proof}}">{{$ut->proof}}</a>
                            @else
                            <figure>
                                <a href="{{Storage::url($ut->proof)}}" target="_blank">
                                    <img
                                        src="{{Storage::url($ut->proof)}}"
                                        />
                                </a>
                            </figure>
                            @endif
                        </div>
                        <button class="absolute top-2 right-2 btn btn-outline btn-error btn-sm" wire:click="reject({{$ut->id}})">Отклонить</button>
                        {{-- <livewire:user-task-show-screenshots wire:key="{{$ut->id}}" user_task_id="{{$ut->id}}"/> --}}
                    </div>
                @endforeach
            </div>
            {{-- <div class="border-1 border-green-300 rounded-md p-4">
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
            </div> --}}
        </div>

    </x-slot>

    <x-slot name="buttons">
        <button class="btn btn-outline" wire:click="$dispatch('closeModal')">Закрыть</button>
    </x-slot>
</x-modal>