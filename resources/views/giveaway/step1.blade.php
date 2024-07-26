<section class="section-1">
    <div class="bg-white my-4" >
        <div
            class="flex flex-col py-10 px-8 text-center text-lg">
            <h1>Раздача Робуксов — получить Робуксы бесплатно в Роблоксе</h1>
            <p class="animated-pulsating-text">Готовим вас к раздаче Робуксов...</p>
            <x-countdown></x-countdown>
            <div class="flex flex-col py-10 px-8 text-left gap-4">
                {{-- <x-input-label for="nickname" value="Имя пользователя" />
                <x-text-input id="nickname" class="block mt-1 w-full" type="text" />
                <x-input-label for="platform"  value="Платформа" />
                <select id="platform"><option>Android</option><option>Windows</option><option>Xbox One</option><option>IOS</option><option>MacOS</option></select> --}}
            </div>
            
            <div class="flex flex-col items-center">
                <a href="{{ route('giveaway.quiz', ['step' => intval($step)+1]) }}"
                    class="block quiz-action-btn text-center max-w-96 my-4" style="display:none">Получить Robux бесплатно</a>
            </div>

        </div>
    </div>
</section>