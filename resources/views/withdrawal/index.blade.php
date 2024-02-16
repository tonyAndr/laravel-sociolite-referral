<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 bark:text-gray-200 leading-tight">
            {{ __('Вывод робуксов') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white bark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 bark:text-gray-100">
                    <p class="text-rose-500 font-bold text-lg">Вывод робуксов заработает с 16.02.2024!</p>
                    <p>
                        Переведи заработанные робуксы на свой игровой счет. Введи нужное количество, нажмите "Перевести"
                        и следуйте инструкции.
                    <form method="get" action="{{ route('withdrawal.index') }}" class="mt-6 space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="robux" :value="__('Robux')" />
                            <x-text-input id="robux" name="robux" type="number" class="mt-1 block w-full"
                                value="10" min="10" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('robux')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button id="btn_withdraw">{{ __('Перевести') }}</x-primary-button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="enter-nickname" :show="$errors->userDeletion->isNotEmpty()" focusable>
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
