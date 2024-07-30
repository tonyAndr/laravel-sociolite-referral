<section class="section-1">
    <div class="bg-white my-4">
        <div
            class="flex flex-col py-10 px-8 text-center text-lg backdrop-blur-md">
            <h1>Раздача Робуксов — шаг 4</h1>
            <div class="flex flex-col items-center mb-6 bark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <p>Для участия в раздаче нужно подписаться на наш канал:</p>
    
                <a href="https://t.me/LuchBux" target="_blank" class="block join-channel-btn text-center max-w-96 mb-4"><i class="fa-brands fa-telegram fa-telegram-white pr-4"></i>LuchBux.Fun</a>
            </div>
            <x-countdown></x-countdown>
            

            <div class="flex flex-col items-center">
                @auth
                <a href="{{ route('giveaway', ['participant' => 1]) }}"
                    class="block quiz-action-btn text-center max-w-96 my-4" style="display:none">Участвовать в раздаче</a>
                @else
                    <a href="{{ route('login', ['participant' => 1]) }}"
                        class="block quiz-action-btn text-center max-w-96 my-4" style="display:none">Участвовать в раздаче</a>
                @endauth
            </div>

        </div>
    </div>
</section>