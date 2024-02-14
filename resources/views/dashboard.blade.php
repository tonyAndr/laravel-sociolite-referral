<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
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
        <h3 class="m-6">Офферволы</h3>
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('offerwall.cpalead') }}">
                <div
                    class="grow sm:grow-0 sm:w-60 h-32 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg flex items-center justify-center">
                    <img class="" src="/images/offers/cpa_lead.png">
                </div>
            </a>
            <a href="{{ route('offerwall.ayetstudios') }}">
                <div
                    class="grow sm:grow-0 sm:w-60 h-32 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg flex items-center justify-center">
                    <img src="/images/offers/ayetstudios.png">
                </div>
            </a>
        </div>
    </div>
</x-app-layout>
