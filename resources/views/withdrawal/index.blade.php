<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Вывод робуксов') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
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
</x-app-layout>
