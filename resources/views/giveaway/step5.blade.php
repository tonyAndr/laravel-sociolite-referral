<section class="section-1">
    <div class="bg-white my-4">
        <div
            class="flex flex-col py-10 px-8 text-center text-lg">
            <h1>Раздача Робуксов — шаг 5</h1>
            <p>Если вы хотите получить бесплатные вещи и предметы для своего персонажа, для это-го выберете категорию:</p>
            <div class="flex flex-col py-10 px-8 text-center" >
                <select id="items"><option>Одежда</option><option>Внешность</option><option>Предметы</option></select>
            </div>
            <x-countdown></x-countdown>

            <div class="flex flex-col items-center">
                <a href="{{ route('login') }}"
                    class="block quiz-action-btn text-center max-w-96 my-4" style="display:none">Получить</a>
            </div>


        </div>
    </div>
</section>