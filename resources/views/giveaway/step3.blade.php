<section class="section-1">
    <div class="bg-white my-4">
        <div
            class="flex flex-col py-10 px-8 text-center text-lg items-center">
            <h1>Раздача Робуксов — шаг 3</h1>
            <p>Обязательно дождитесь окончания процесса!!!</p>
            <x-countdown-circle/>
            <p class="animated-pulsating-text">Поиск и получение Robux пользователем…</p>

            <div class="flex flex-col items-center">
                <a href="{{ route('giveaway.quiz', ['step' => intval($step)+1]) }}"
                    class="block quiz-action-btn text-center max-w-96 my-4" style="display:none">Посмотреть результаты</a>
            </div>

        </div>
    </div>
</section>