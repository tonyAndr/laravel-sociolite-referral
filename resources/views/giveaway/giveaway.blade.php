@php
    // dd($you_won);
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <title>Раздача Робуксов — получить Robux бесплатно в Roblox 2024</title>
    <meta name="description"
        content="На этой странице Вы можете поучаствовать в раздаче Robux и получить их совершенно бесплатно на свой аккаунт в Roblox.">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="/logo.png">
    <meta name='robots' content='index, follow' />
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireScripts
    @livewireStyles

    <x-external-scripts />
</head>

<body>

    <div
        class="relative min-h-screen bg-dots-darker bg-center bg-gray-100 bark:bg-dots-lighter bark:bg-gray-900 selection:bg-red-500 selection:text-white">
        @include('layouts.navigation')
        <div class="main-content">
            <input hidden id="countdown_page_reload"/>
            <input hidden id="last_giveaway_won" value="{{$you_won === true ? 1 : 0}}"/>
            <section class="section-countdown">
                <div class="bg-gray-300 py-10 px-10 flex flex-col items-center">
                    @if (!$user_is_participating && !$subscription_needed)
                        <div class="flex flex-col items-center">
                            <a href="{{ route('giveaway.quiz', ['step' => 1]) }}"
                                class="block home-main-action-btn text-center max-w-96 mb-4">УЧАСТВОВАТЬ В
                                РАЗДАЧЕ</a>
                        </div>
                    @endif
                    @if ($subscription_needed)
                        <div class="flex flex-col items-center">
                            <p>Победить могут только подписчики канала!</p>
                            <a href="{{ route('giveaway.quiz', ['step' => 3]) }}"
                                class="block join-channel-btn text-center max-w-96 mb-4">Подпишись на Luchbux.Fun</a>
                        </div>
                    @endif
                        
                    <div class="flex flex-row justify-between pb-4 text-lg min-w-48 max-w-96">
                        <div class="giveaway-reward flex flex-col items-center ">
                            <div>Награда</div>
                            <div class="text-xl font-bold text-lime-600">R$ {{ $reward }}</div>
                        </div>
                        <div class="giveaway-participants flex flex-col items-center">
                            <div>Участники</div>
                            <div class="text-xl font-bold text-lime-600">🧍 {{ count($participants) }}</div>
                        </div>
                    </div>
                    <input id='countdown_time' hidden type='number' value='{{ $countdown_time }}' />
                    <div class="flex flex-col items-center">
                        <p class="font-bold">Осталось времени</p>
                        <x-countdown />
                        <p class="font-bold">
                            {{ $user_is_participating && !$subscription_needed ? "Ты участвуешь в розыгрыше! Шанс выиграть: $chance%" : "Ты еще не участвуешь в розыгрыше"}}
                        </p>
                        @auth
                            <livewire:task-available-reminder is_participating="{{intval($user_is_participating)}}" user_id="{{Auth::user()->id}}"/>
                        @endauth
                    </div>
                </div>
            </section>
            <section class="section-winners">
                <livewire:last-giveaway-winners />
            </section>
            <section class="section-1">
                <div class="" style="background-image: url(/images/roblox_bg_3.jpg)">
                    <div
                        class="flex flex-col py-10 px-8 text-center bg-black text-lg backdrop-blur-sm backdrop-invert bg-black/90 text-white">
                        <h1>Раздача Робуксов — получить Робуксы бесплатно в Роблоксе</h1>

                        <p>У вас уже есть Roblox на телефоне? Хотели бы получить много робуксов побыстрее и без обмана?
                        </p>
                        <p>Предлагаем
                            самый простой и проверенный метод. Рабочий способ, который одинаково легко и быстро работает
                            как на
                            андроид, так и на айфон.</p>
                    </div>
                </div>
            </section>
            <div>
                {{-- block --}}
                <!-- Yandex.RTB R-A-6005102-3 -->
                <div id="yandex_rtb_R-A-6005102-3"></div>
                <script>
                    window.yaContextCb.push(() => {
                        Ya.Context.AdvManager.render({
                            "blockId": "R-A-6005102-3",
                            "renderTo": "yandex_rtb_R-A-6005102-3"
                        })
                    })
                </script>

                {{-- fullscreen --}}
                <!-- Yandex.RTB R-A-6005102-4 -->
                <script>
                    window.yaContextCb.push(() => {
                        Ya.Context.AdvManager.render({
                            "blockId": "R-A-6005102-4",
                            "type": "fullscreen",
                            "platform": "touch"
                        })
                    })
                </script>

                {{-- footer --}}
                <!-- Yandex.RTB R-A-6005102-5 -->
                <script>
                    window.yaContextCb.push(() => {
                        Ya.Context.AdvManager.render({
                            "blockId": "R-A-6005102-5",
                            "type": "floorAd",
                            "platform": "touch"
                        })
                    })
                </script>
            </div>
            <section class="simple-info">
                <div class="" style="background-image: url(/images/roblox_bg_3.jpg)">
                    <div
                        class="flex flex-col backdrop-blur-sm bg-white/90 bg-center py-10 px-8 text-justify items-center">
                        <h2>Почему стоит попробовать наш способ</h2>
                        <p>Множество геймеров в России хотели бы получить много робуксов на свой телефон без каких-либо
                            усилий. И мы
                            даем им такую возможность. У нас проходит раздача робуксов без обмана. Вот несколько причин,
                            почему вам
                            подходит наш сайт:</p>
                        <ol>
                            <li><strong>Моментально</strong>. Получение робуксов буквально за минуту. Вы можете просто
                                испытать
                                удачу. Если повезет – вывести призовой счет на ваш аккаунт. И для этого нужно приложить
                                минимум
                                усилий.</li>
                            <li><strong>Без доната</strong>. Все, что от вас потребуется, это профиль на нашей площадке.
                                И немного
                                удачи. Наша система работает без денег и без кода (промокода). От геймера требуется
                                сделать всего
                                пару кликов.</li>
                            <li><strong>Безопасно</strong>. Все действия проходят в рамках нашей площадки. Без
                                скачивания сторонних
                                APK или файлов-дистрибутивов на компьютер. Наша площадка следит за безопасностью своих
                                пользователей. Поэтому все действия проходят внутри сайта. Можете быть уверены – у нас
                                безопасно,
                                без вирусов и прочего вредоносного ПО.</li>
                            <li><strong>На русском языке</strong>. Не нужно переходить на сторонние площадки или
                                иностранные сайты.
                                От вас потребуется сделать пару кликов. Весь интерфейс сайта на русском.</li>
                        </ol>
                        <p>Вы хотите пополнить счет в Роблоксе на круглую сумму? Тогда действуете согласно нашим
                            инструкциям ниже.
                        </p>
                        <h2 class="center">Испытай удачу</h2>
                        <p>Наша раздача робуксов бесплатно проходит 3 раза в день. В 11, в 15 и в 20 часов МСК. Ежедневно. Вы можете получить робуксы
                            бесплатно,
                            затем вывести весь приз на свой официальный аккаунт в Roblox после зачисления приза на
                            внутренний
                            виртуальный счет нашей площадки.</p>
                        <p>Что от вас потребуется сделать, чтобы получить бесплатно R$:</p>
                        <ol>
                            <li>Зарегистрировать свой профиль на площадке. Можно войти разными используя
                                авторизацию через телеграм.</li>
                            <li>Войти на специальную страницу с раздачей 100 робуксов.</li>
                            <li>Нажать на кнопку: «Присоединиться к раздаче».</li>
                            <li>Дождаться окончания розыгрыша.</li>
                        </ol>
                        <p>Мы моментально публикуем результаты. Вы узнаете о победе в личном кабинете или в специальном
                            уведомлении.
                            Необязательно иметь смартфон с запущенным Roblox под рукой, чтобы получить награду. Наш сайт
                            работает
                            без приложения, бесплатно. Все, что нужно – войти под своим профилем. Получить робуксы
                            бесплатно
                            буквально за 1 клик.</p>
                        <p>Если вы не смогли выиграть – не стоит отчаиваться. Розыгрыш робуксов идет каждый час. Поэтому
                            вы можете
                            посещать данную страницу регулярно, через каждые 60 минут. Участвуйте и побеждайте! Мы верим
                            в вашу
                            удачу!</p>

                    </div>
                </div>
            </section>


            <section class="how-to-withdraw">
                <div class="bg-clip-border bg-center bg-no-repeat bg-cover text-white bg-black"
                    style="background-image: url(/images/roblox_bg_2.png)">
                    <div class="flex flex-col py-5 px-8 items-center bg-black/70 text-justify">

                        <h2 class="text-center">Вывод приза</h2>
                        <p>Удача вам улыбнулась? Получили робуксы бесплатно? Отлично! Готовы вывести робуксы на
                            официальный профиль
                            Roblox?</p>
                        <p>Вот пошаговый алгоритм:</p>
                        <ol>
                            <li>Перейдите на вкладку «Вывести».</li>
                            <li>Укажите сумму роблоксов на вывод.</li>
                            <li>Выведите валюту на счет в игре. Все операции проходят без комиссии — бесплатно.</li>
                        </ol>
                        <p>Полученные R$ поступят на счет в течение 5-7 дней.</p>
                    </div>
                </div>
            </section>

        </div>
        <x-footer-copyright />
    </div>

</body>

</html>
