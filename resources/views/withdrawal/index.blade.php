<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 bark:text-gray-200 leading-tight">
            {{ __('Вывод робуксов') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-red-300 mb-6 bark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 bark:text-gray-100">
                    <p>Перед выводом нужно создать GamePass в игре. Робуксы поступят на ваш игровой счет через геймпасс.
                        Подробная инструкция, как это сделать тут:</p>
                    <a href="{{ route('withdrawal.instruction') }}"><x-primary-button type="button">Инструкция как
                            создать GamePass</x-primary-button></a>
                </div>
            </div>
            <div class="bg-white bark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 bark:text-gray-100">
                    <p>
                        Переведи заработанные робуксы на свой игровой счет. Введи нужное количество, нажмите "Перевести"
                        и следуйте инструкции.</p>
                    <p><strong>Минимальное количество - 20 робуксов</strong>.</p>
                    <form method="get" action="{{ route('withdrawal.index') }}" class="mt-6 space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="robux" :value="__('Robux')" />
                            <x-text-input id="robux" name="robux" type="number" class="mt-1 block w-full"
                                value="20" min="20" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('robux')" />
                        </div>

                        <p>Создай геймпас в игре и укажи его цену такую, как в поле ниже.</p>

                        <div class="font-bold text-xl">Цена на GamePass: <span id="gamepass_price"
                                class="gamepass-price text-3xl">29</span> (укажите ее при создании геймпасса)</div>

                        <div>
                            <x-input-label for="gamepass" :value="__('Ссылка на GamePass')" />
                            <x-text-input id="gamepass" name="gamepass" type="text" class="mt-1 block w-full"
                                required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('gamepass')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button id="btn_withdraw">{{ __('Перевести') }}</x-primary-button>
                        </div>
                    </form>
                </div>

            </div>
            <!-- Withdrawals table -->
            <div class="max-w-7xl mx-auto py-6">
                <h3 class="py-2">Заявки на вывод</h3>
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
