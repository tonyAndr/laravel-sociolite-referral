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
                <a href="{{ route('giveaway.quiz', ['step' => intval($step)+1]) }}"
                    class="block quiz-action-btn text-center max-w-96 my-4" style="display:none">Далее</a>
            </div>
            <p>Внимание! Бесплатные предметы и вещи в Roblox переходи <a href="{{ route('giveaway.quiz', ['step' => 5]) }}"
                class="">по ссылке</a>!</p>

        </div>
    </div>
</section>