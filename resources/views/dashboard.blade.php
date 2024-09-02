<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 bark:text-gray-200 leading-tight">
            {{ __('Заработай робуксы') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto px-6 lg:px-8 ">
        <div class="flex flex-col sm:flex-row gap-4">
            <div
                class="grow sm:grow-0 sm:w-60 h-32 bg-cyan-600 text-white overflow-hidden shadow-sm rounded-lg flex flex-col justify-center items-center">
                <p class="text-3xl font-bold"><span class="text-slate-300">R$</span> {{ Auth::user()->robux }}</p>
                <span class="text-slate-300">Текущий баланс</span>
            </div>
        </div>
                {{-- @if (Auth::user()->is_admin) --}}
                <h3 class="m-6">Задания</h3>
                <div class="flex flex-col sm:flex-row sm:flex-wrap gap-4">
                    @if (count($user_tasks))
                    @foreach ($user_tasks as $ut)
                        <a href="{{ route('tasks.user_task', ['id' => $ut->id]) }}" id="user_task_btn">
                            <div
                                class="grow sm:grow-0 sm:w-60 min-h-32 bg-white bark:bg-gray-800 overflow-hidden shadow-sm rounded-lg flex flex-col relative text-black">
                                <p class="uppercase rounded bg-white px-2 font-bold text-cyan-600 text-sm ">
                                        @if ($ut->user_task_status)
                                            @if ($ut->user_task_status === 'active')
                                            Ждет выполнения
                                            @else
                                            Выполнена
                                            @endif
                                        @else
                                            🔥🔥🔥
                                        @endif
                                    </p>  
                                <p class="uppercase font-bold p-2 text-center">{{$ut->title}}</p>
                                <p class="text-end rounded bg-white px-2 font-bold text-success">+ {{$ut->user_reward}} Робукс</p>
                                
                            </div>
                        </a>
                    @endforeach
                    @else
                    <p>Новых заданий пока нет, но они скоро появятся!</p>
                    @endif

                    {{-- <a href="{{ route('tasks.yandex_reward') }}" id="yandex_task_btn">
                        <div
                            class="grow sm:grow-0 sm:w-60 min-h-32 bg-amber-400 bark:bg-gray-800 overflow-hidden shadow-sm rounded-lg flex  items-center justify-center relative text-black">
                            <p class="uppercase font-bold text-center"><span class="text-red-500">П</span>росмотр <span class="text-red-500">р</span>екламы<p>
                            <p class="absolute end-2 bottom-0 font-bold text-success drop-shadow-md">+ 0.05 Робукс</p>
                        </div>
                    </a> --}}
    
                </div>
            {{-- @endif --}}
            {{-- <h3 class="m-6">Офферволы</h3>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('offerwall.cpalead') }}">
                    <div
                        class="grow sm:grow-0 sm:w-60 h-32 bg-white bark:bg-gray-800 overflow-hidden shadow-sm rounded-lg flex items-center justify-center">
                        <img class="p-4" src="/images/offers/cpa_lead.png">
                    </div>
                </a>
                <a href="{{ route('offerwall.mylead') }}">
                    <div
                        class="grow sm:grow-0 sm:w-60 h-32 bg-slate-600 bark:bg-gray-800 overflow-hidden shadow-sm rounded-lg flex items-center justify-center">
                        <img class="p-4" src="/images/offers/mylead_logo.png">
                    </div>
                </a>

            </div> --}}

    </div>
</x-app-layout>
