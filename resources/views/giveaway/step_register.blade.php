<section class="section-1">
    <div class="bg-white my-4">
        <div class="flex flex-col py-10 px-8 text-center text-lg">
            <h1>Раздача Шаг {{$step}} - проверка пользователя</h1>
            @auth
                <p class="animated-pulsating-text">Обнаружен существующий пользователь, осуществляем проверку безопасности...
                </p>
            @else
                <p class="animated-pulsating-text">Ищем пользователя в нашей базе данных...</p>

            @endauth
            <x-countdown></x-countdown>
            <div class="quiz-action-block" style="display:none">
                <div class="flex flex-col items-center ">
                    @auth
                        <a href="{{ route('giveaway.quiz', ['step' => intval($step) + 1]) }}"
                            class="block quiz-action-btn text-center max-w-96 my-4">Следующий шаг</a>
                    @else
                        <a href="{{ route('login', ['giveaway_login' => 1]) }}"
                            class="block quiz-action-btn text-center max-w-96 my-4">Авторизоваться на сайте</a>
                    @endauth
                </div>
            </div>

        </div>
    </div>
</section>
