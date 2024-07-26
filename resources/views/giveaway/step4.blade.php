<section class="section-1">
    <div class="bg-white my-4">
        <div
            class="flex flex-col py-10 px-8 text-center text-lg backdrop-blur-md">
            <h1>Раздача Робуксов — шаг 4</h1>
            <p>Robux поступят на ваш аккаунт через:</p>
            <x-countdown></x-countdown>
            <a href="{{ route('giveaway.quiz', ['step' => 1]) }}"
                class="">Добавить вам еще Робукс?</a>
            <p>Пока ждешь поделись с друзьями:</p>
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