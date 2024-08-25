<section class="section-1">
    <div class="bg-white my-4" >
        <
            class="flex flex-col py-10 px-8 text-center text-lg">
            <h1>Раздача Робуксов — получить Робуксы бесплатно в Роблоксе</h1>
            <p class="animated-pulsating-text">Готовим тебя к раздаче Робуксов...</p>
            <x-countdown></x-countdown>
            
            <div class="quiz-action-block" style="display:none">
<div class="flex flex-col items-center">
                <a href="{{ route('giveaway.quiz', ['step' => intval($step)+1]) }}"
                    class="block quiz-action-btn text-center max-w-96 my-4">Получить Robux бесплатно</a>
            </div>
            </div>
            


        </div>
    </div>
</section>