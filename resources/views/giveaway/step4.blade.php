<section class="section-1">
    <div class="bg-white my-4">
        <div class="flex flex-col py-10 px-8 text-center text-lg">
            <h1>Раздача Робуксов — Шаг 4</h1>
            <p>Расскажи друзьям в ВК или Telegram или WhatsApp чтобы получить Robux бесплатно. :)</p>

            {!! ShareButtons::page(route('giveaway'), 'Присоединяйся и получай робуксы!', [
                'title' => 'Присоединяйся и получай робуксы!',
                'rel' => 'nofollow noopener noreferrer',
            ])->telegram()->whatsapp()->vkontakte()->copylink()->render() !!}
            <div class="flex flex-col items-center ">
                <x-countdown-circle />
            </div>
            <div class="quiz-action-block" style="display:none">
                <div class="flex flex-col items-center ">
                    <a href="{{ route('giveaway.quiz', ['step' => intval($step) + 1]) }}"
                        class="block quiz-action-btn text-center max-w-96 my-4">Далее</a>
                </div>
            </div>


        </div>
    </div>
</section>
