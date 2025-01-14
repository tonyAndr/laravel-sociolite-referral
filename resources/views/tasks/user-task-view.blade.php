<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 bark:text-gray-200 leading-tight">
            Задание: {{ $task->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('dashboard') }}"><x-primary-button type="" class="mx-4">
                    << К списку заданий</x-primary-button></a>
            <div class="bg-white border-2 border-success my-6 bark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 bark:text-gray-100">
                    <div class="flex flex-row justify-center text-3xl">
                        <div class="text-center p-4">Награда</div>
                        @if ($task->task_type === 0)
                            <div class="text-center p-4">
                                <span class="text-yellow-500">R$</span>{{ $task->user_reward }}
                            </div>
                        @endif
                    </div>
                    @if ($task->task_type === 0)
                    <p class="text-gray-500 text-center">Выполняя задания ты зарабатываешь робуксы - внутриигровую
                        валюту в Roblox. </p>
                    @else
                    <p class="text-gray-500 text-center">Награда зависит от просмотров видео </p>
                    @endif
                </div>
                

            </div>

            @if ($user_status === 'active' && $task->task_type === 0)
            <div class="relative bg-white mb-6 bark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 bg-warning bark:text-gray-100">
                    <p class="text-gray-500 text-center">Осталось времени на выполнение задания: <strong>{{$expires_min > 0 ? "~" . $expires_min . " мин." : "меньше минуты"}} </strong></p>
                </div>
            </div>
            @endif

            <div class="relative bg-white mb-6 bark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 bark:text-gray-100">
                    @if ($task->task_type === 0)
                        <p class="font-bold">Если ты уже регистрировался в данном сервисе или игре ранее - ВЫПОЛНЯТЬ ЗАДАНИЕ НЕЛЬЗЯ. Оно не будет принято.</p>
                        <p class="font-bold">Время выполнения задания - 1 час. Если через час задание не выполнено - оно будет автоматически отменено.</p>
                        <h3 class="mt-3">Описание задания</h3>
                        <p>Для выполнения задания тебе необходимо перейти по реферальной ссылке (указана ниже) и
                            зарегистрироваться там (или начать разговор с ботом или запустить игру по ссылке). </p>
                        <div class="flex flex-col">
                            <p class="text-gray-500">Реферальная ссылка</p>
                            <a href="{{ $task->ref_url }}" target="_blank" class="btn">Перейти: {{ $task->ref_url }}</a>
                        </div>
                    @endif

                    @if ($task->description)
                        <div class="py-4">
                            <h3>Детали задания</h3>
                            <p>{{ $task->description }}</p>
                            <p>Например, за <strong>100 просмотров - 10 робуксов, а за 1000 - 50 робуксов</strong>.</p>
                            <p> Пример видео, которое ты можешь создать: </p>
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/djs4dVZha0U?si=varpw_oVbe82lE2M" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                    @endif
                    @if ($user_status === 'active')
                        <p>Все условия должны быть выполнены, иначе задача не будет принята!</p>
                    @endif
                </div>

            </div>
            <div class="relative bg-white bark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if ($user_status === 'active')
                    <div class="p-6 text-gray-900 bark:text-gray-100">
                        <h3>Подтверждение выполнения</h3>
                        <form id="finish_task_form" method="post" action="{{ route('tasks.end_task') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <input hidden name="task_id" value="{{ $task->id }}" />
                            <input hidden name="action_finish" />

                            @if ($task->proof_type === 'screenshot' || $task->proof_type === 'screenshot_nickname')
                                @if ($task->proof_type === 'screenshot_nickname')
                                <p>Укажи свой ник в игре <strong>{{ $task->product->description }}</strong></p>
                                    <x-input-label for="nickname" value="Никнейм"></x-input-label>
                                    <input id="nickname" name="nickname" type="text"
                                        class="input input-bordered w-full max-w-xs" required />
                                    <x-input-error class="m-2" :messages="$errors->get('nickname')" />
                                    
                                @endif
                                <p>Для выполнения задания нужно загрузить скриншот(ы), подтверждающий выполненные
                                    действия из игры или регистрации на сайте <strong>{{ $task->product->description }}</strong>.</p>
                                <x-input-label for="screenshot_upload" value="Загрузить скриншот"></x-input-label>
                                <input id="screenshot_upload" name="screenshots" type="file"
                                    class="file-input file-input-bordered w-full max-w-xs" required multiple />
                                <x-input-error class="mt-2" :messages="$errors->get('screenshots')" />
                                <p class="font-bold">Если вместо скриншота заружено любое другое изображение или файл не являющиеся пруфом, вознаграждение не будет выплачено, а аккаунт может быть заблокирован.</p>
                            @endif
                            @if ($task->proof_type === 'text')
                                <x-input-label for="text_proof" value="Ссылка на твоё видео"></x-input-label>
                                <input id="text_proof" name="text_proof" type="text"
                                    class="input input-bordered w-full max-w-xs" required />
                            @endif
                        </form>
                        <form id="cancel_task_form" method="post" action="{{ route('tasks.end_task') }}">
                            @csrf
                            <input hidden name="task_id" value="{{ $task->id }}" />
                            <input hidden name="action_cancel" />

                        </form>
                    </div>
                    <div class="p-6 text-gray-900 bark:text-gray-100 flex flex-row justify-between">
                        <button form="finish_task_form" name="btn-finish"
                            class="btn btn-outline btn-success">Завершить</button>
                        <button form="cancel_task_form" name="btn-cancel" class="btn btn-outline">Отменить</button>
                    </div>
                @endif

                @if ($user_status === 'preview')
                    <form id="start_task_form" method="post" action="{{ route('tasks.start') }}">
                        @csrf
                        <input hidden name="task_id" value="{{ $task->id }}" />
                        <input hidden name="action_start" />
                        <div class="p-6 text-gray-900 bark:text-gray-100">
                            <button name="btn-start" class="btn btn-outline btn-success">Начать</button>

                        </div>
                    </form>
                @endif

                @if ($user_status === 'finished')
                    @if ($task->task_type === 0)
                    <div
                        class="p-6 text-gray-900 bark:text-gray-100 flex flex-row justify-between font-bold text-green-500">
                        <p>Задание выполнено. Робуксы уже зачислены на баланс.</p>
                    </div>
                    @else
                    <div
                        class="p-6 text-gray-900 bark:text-gray-100 flex flex-row justify-between font-bold text-green-500">
                        <p>Задание выполнено. Мы будем проверять количество просмотров и начислять робуксы если набралось достаточное количество.</p>
                    </div>
                    @endif
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
