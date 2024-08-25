<section class="section-1">
    <div class="bg-white my-4">
        <div class="flex flex-col py-10 px-8 text-center text-lg backdrop-blur-md">
            <h1>Раздача Робуксов — ПОСЛЕДНИЙ ШАГ</h1>
            <div class="flex flex-col items-center mb-6 bark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <p>Последнее обязательное условие участия в раздаче - подпишись на канал, где мы публикуем промокоды,
                    фишки и секреты для Роблокса:</p>

                <a href="https://t.me/fishki_roblox" target="_blank"
                    class="block join-channel-btn text-center max-w-96 mb-4"><i
                        class="fa-brands fa-telegram fa-telegram-white pr-4"></i>Канал Фишки Роблокса</a>
            </div>
            <x-countdown></x-countdown>
            <input hidden id="tg_channel_id" value="{{ env('TELEGRAM_FISHKI_CHANNEL_LIVE_ID') }}" />

            <div class="quiz-action-block" style="display:none">
                <div class="flex flex-col items-center ">
                    <p class="animated-pulsating-text quiz-sub-check-text">Проверяем подписку на канал...</p>
                    @auth
                        <a href="{{ route('giveaway', ['participant' => 1]) }}"
                            class="block quiz-action-btn text-center max-w-96 my-4" style="display:none">Участвовать в раздаче</a>
                    @else
                        <a href="{{ route('login', ['participant' => 1]) }}"
                            class="block quiz-action-btn text-center max-w-96 my-4" style="display:none">Войти</a>
                    @endauth
                </div>
            </div>


        </div>
    </div>
</section>
