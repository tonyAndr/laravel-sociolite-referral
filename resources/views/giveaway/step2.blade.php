<section class="section-1">
    <div class="bg-white my-4">
        <div class="flex flex-col py-10 px-8 text-center text-lg">
            <h1>Раздача Робуксов — шаг {{$step}}</h1>
            <div class="flex flex-col items-center mb-6 bark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <p>Для участия в раздаче нужно подписаться на наш канал, где мы сообщаем о победителях и новых способах
                    получить робуксы:</p>

                <a href="https://t.me/LuchBux" target="_blank" class="block join-channel-btn text-center max-w-96 mb-4"><i
                        class="fa-brands fa-telegram fa-telegram-white pr-4"></i>Подписаться на LuchBux.Fun</a>
            </div>

            <x-countdown></x-countdown>
            <input hidden id="tg_channel_id" value="{{ env('TELEGRAM_LUCHBUX_CHANNEL_LIVE_ID') }}" />
            <div class="quiz-action-block" style="display:none">
                <div class="flex flex-col items-center ">
                    <a href="{{ route('giveaway.quiz', ['step' => intval($step) + 1]) }}"
                        class="block quiz-action-btn text-center max-w-96 my-4">Далее</a>
                </div>
            </div>


        </div>
    </div>
</section>
