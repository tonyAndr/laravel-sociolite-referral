<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 bark:text-gray-200 leading-tight">
            {{ __('Вывод робуксов') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-yellow-300 mb-6 bark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 bark:text-gray-100">
                    <p>После того как ты оставишь заявку, мы вышлем тебе в ТЕЛЕГРАМ код подарочной карты для получения робуксов в игре. </p>
                    <p>Активировать код нужно на официальном сайте: <a href="https://www.roblox.com/redeem" target="_blank">https://www.roblox.com/redeem</a> </p>
                    {{-- <a href="{{ route('withdrawal.instruction') }}"><x-primary-button type="button">Инструкция как
                            создать GamePass</x-primary-button></a> --}}
                </div>
            </div>
            <div class="relative bg-white bark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 bark:text-gray-100">
                    <p>Доступно для вывода: {{count($select_options) ? $select_options[count($select_options)-1] : 0}}</p>
                    <p>
                        Переведи заработанные робуксы на свой игровой счет. Выбери нужное количество и нажми Получить.</p>
                    <p><strong>Минимальное количество - 100 робуксов</strong>.</p>
                    @if(count($select_options))
                        <form method="get" action="{{ route('withdrawal.index') }}" class="mt-6 space-y-6">
                            @csrf
                            <input hidden id="user_email" name="email" value="{{$user->email}}"/>
                            <div>
                                <x-input-label for="robux" :value="__('Robux')" />
                                {{-- <x-text-input id="robux"  type="number" class="mt-1 block w-full"
                                    value="20" min="20" required autofocus /> --}}
                                <select id="robux" name="robux">
                                    @foreach ($select_options as $k => $v)
                                        <option key="{{$k}}" value="{{$v}}">{{$v}}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('robux')" />
                            </div>

                            {{-- <p>Создай геймпас в игре и укажи его цену такую, как в поле ниже.</p> --}}

                            {{-- <div class="font-bold text-xl">Цена на GamePass: <span id="gamepass_price"
                                    class="gamepass-price text-3xl">29</span> (укажите ее при создании геймпасса)</div>

                            <div>
                                <x-input-label for="gamepass" :value="__('Ссылка на GamePass')" />
                                <x-text-input id="gamepass" name="gamepass" type="text" class="mt-1 block w-full"
                                    required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('gamepass')" />
                            </div> --}}

                            <div class="flex items-center gap-4">
                                <x-primary-button id="btn_withdraw">{{ __('Получить') }}</x-primary-button>
                            </div>
                        </form>
                    @else
                        <p class="font-bold">Недостаточно робуксов на балансе для вывода. <a href="{{route('giveaway')}}">Получи их бесплатно!</a></p>
                    @endif
                </div>
                <div id="progress_spinner" hidden class="absolute bg-white/75 top-0 bottom-0 right-0 left-0">
                    <div role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">
                        <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                        <span class="sr-only">Думаем...</span>
                    </div>
                </div>
            </div>
            <!-- Withdrawals table -->
            <div class="max-w-7xl mx-auto py-6">
                <h3 class="p-2">Заявки на вывод</h3>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <livewire:withdrawals-table />
                    </div>
                </div>
            </div>
            <!-- /.Withdrawals table -->
        </div>
    </div>



    <x-modal name="insert-gamepass-link" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('withdrawal.create') }}" class="p-6">
            @csrf

            <h2 class="text-lg font-medium text-gray-900 bark:text-gray-100">
                {{ __('Provide your in-game nickname') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 bark:text-gray-400">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
