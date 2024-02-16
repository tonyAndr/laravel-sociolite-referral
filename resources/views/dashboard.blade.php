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
        <h3 class="m-6">Офферволы</h3>
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
            {{-- <a href="{{ route('offerwall.ayetstudios') }}">
                <div
                    class="grow sm:grow-0 sm:w-60 h-32 bg-white bark:bg-gray-800 overflow-hidden shadow-sm rounded-lg flex items-center justify-center">
                    <img src="/images/offers/ayetstudios.png">
                </div>
            </a> --}}
        </div>
        @if (Auth::user()->is_admin)
            <h3 class="m-6">Задания</h3>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('tasks.yandex_reward') }}">
                    <div
                        class="grow sm:grow-0 sm:w-60 h-32 bg-amber-400 bark:bg-gray-800 overflow-hidden shadow-sm rounded-lg flex items-center justify-center relative text-black">
                        <p class="uppercase font-bold"><span class="text-red-500">П</span>росмотр <span class="text-red-500">р</span>екламы<p>
                        <p class="absolute bottom-2 end-4 uppercase rounded bg-white px-2 font-bold text-cyan-600">+ 1 Robux</p>
                    </div>
                </a>

            </div>
        @endif
    </div>
</x-app-layout>
