<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 bark:text-gray-200 leading-tight">
            {{ __('Вывод робуксов') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white bark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 bark:text-gray-100 flex flex-col items-center">
                    <p class="">Проверь, что у тебя хватает робуксов для вывода. Минимум можно вывести 20 робуксов!
                    </p>
                    <h3 class="py-6">Видео-инструкция как создать GamePass</h3>
                    <iframe width="360" height="240"
                        src="https://www.youtube.com/embed/ViLsoxaYWkw?si=pcaaqgGjRGCxHcV0" title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                    <p>В текстовом виде:</p>
                    <ol>
                        <li>Заходите на сайт Roblox с браузера</li>
                        <li>Справа сверху нажимаете на ваш ник</li>
                        <li>Нажимаете на creations, вас перебрасывает на ваш плейс</li>
                        <li>Нажимаете на Store</li>
                        <li>Нажимаете на add pass, вас перебрасывает на roblox creations</li>
                        <li>Нажимаете на ваш плейс</li>
                        <li>Листаете в самый низ, там будет раздел Monetization products, в нем будет кнопка passes, нажимайте</li>
                        <li>Нажимайте на create a pass</li>
                        <li>Даете ему любое имя (не пишите в названии что то упоминающее сайт, лучше напишите сумму покупки)</li>
                        <li>Дальше ставьте цену, которую мы указываем при выводе, смотрите на скришнотах ниже</li>
                        <li>Скопируйте ссылку на геймпасс в форму для вывода</li>
                    </ol>
                    <h3 class="py-6">Цена на GamePass</h3>
                    <img src="/images/withdrawals/gamepass_price.png" />
                    <p>Проверь, что количество робуксов, которое ты получишь равно сумме вывода.</p>
                    <h3 class="py-6">Получение ссылки</h3>
                    <img src="/images/withdrawals/gamepass_url.png" />
                    <p>Ссылка нужна обязательно для вывода робуксов</p>
                    <h3 class="py-6">Заявка на вывод</h3>
                    <img src="/images/withdrawals/place_order.png" />
                    <p>Нажми на кнопку Перевести, чтобы отправить заявку</p>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
