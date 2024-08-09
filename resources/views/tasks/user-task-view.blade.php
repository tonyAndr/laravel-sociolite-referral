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
                        <div class="text-center p-4"><span class="text-yellow-500">R$</span>{{ $task->user_reward }}
                        </div>
                    </div>
                    <p class="text-gray-500 text-center">Выполняя задания ты зарабатываешь робуксы - внутриигровую
                        валюту в Roblox. </p>

                </div>

            </div>
            <div class="relative bg-white mb-6 bark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 bark:text-gray-100">
                    <h3>Описание задания</h3>
                    <p>Для выполнения задания тебе необходимо перейти по реферальной ссылке (указана ниже) и
                        зарегистрироваться на сайте. </p>
                    <div class="flex flex-col">
                        <p class="text-gray-500">Реферальная ссылка</p>
                        <a href="{{ $task->ref_url }}" target="_blank" class="btn">Перейти: {{ $task->ref_url }}</a>
                    </div>

                    @if ($task->description)
                        <div class="py-4">
                            <h3>Детали задания</h3>
                            <p>{{ $task->description }}</p>
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
                        <form id="finish_task_form" method="post" action="{{ route('tasks.end_task') }}" enctype="multipart/form-data">
                            @csrf
                            <input hidden name="task_id" value="{{ $task->id }}" />

                            @if ($task->proof_type === 'screenshot')
                                <p>Для выполнения задания нужно загрузить скриншот(ы), подтверждающий выполненные
                                    действия.</p>
                                <x-input-label for="screenshot_upload" value="Загрузить скриншот"></x-input-label>
                                <input id="screenshot_upload" name="screenshots" type="file"
                                    class="file-input file-input-bordered w-full max-w-xs" required multiple />
                                    <x-input-error class="mt-2" :messages="$errors->get('screenshots')" />
                                <p>Если по заданию нужно выполнить несколько действий, то загрузите скриншоты с
                                    результатом выполнения каждого из них.</p>
                            @endif
                            @if ($task->proof_type === 'text')
                                <x-input-label for="text_proof" value="Комментарий"></x-input-label>
                                <input id="text_proof" name="text_proof" type="text"
                                    class="input input-bordered w-full max-w-xs" required />
                            @endif
                        </form>
                        <form id="cancel_task_form" method="post" action="{{ route('tasks.end_task') }}">
                            @csrf
                            <input hidden name="task_id" value="{{ $task->id }}" />

                        </form>
                    </div>
                    <div class="p-6 text-gray-900 bark:text-gray-100 flex flex-row justify-between">
                        <button form="finish_task_form" name="btn-finish"
                            class="btn btn-outline btn-success">Завершить</button>
                        <button form="cancel_task_form" name="btn-cancel" class="btn btn-outline">Отменить</button>
                    </div>
                @endif

                @if ($user_status === 'preview')
                    <form method="post" action="{{ route('tasks.start') }}">
                        @csrf
                        <input hidden name="task_id" value="{{ $task->id }}" />
                        <div class="p-6 text-gray-900 bark:text-gray-100">
                            <button name="btn-start" class="btn btn-outline btn-success">Начать</button>

                        </div>
                    </form>
                @endif

                @if ($user_status === 'finished')
                    <div class="p-6 text-gray-900 bark:text-gray-100 flex flex-row justify-between font-bold text-green-500">
                        <p>Задание выполнено. Робуксы уже зачислены на баланс.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
