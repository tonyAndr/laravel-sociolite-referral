<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Example Title</title>
    <meta name="description" content="Example description">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="/logo.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireScripts
    @livewireStyles

    <x-external-scripts />
</head>

<body>

    <div
        class="relative min-h-screen bg-dots-darker bg-center bg-gray-100 bark:bg-dots-lighter bark:bg-gray-900 selection:bg-red-500 selection:text-white">
        @include('layouts.navigation')
        {{-- @if (Route::has('login'))
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
            @auth
                <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 bark:text-gray-400 bark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Получи робуксы</a> 
            @else
                <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 bark:text-gray-400 bark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">{{ __("Log in") }}</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 bark:text-gray-400 bark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">{{ __("Register") }}</a>
                @endif
            @endauth
        </div>
        @endif --}}
        <div class="main-content">

            <div class="flex flex-col pt-10 px-2 items-center">
                <div>
                    <h1 class="text-center">Робуксы БЕСПЛАТНО без обмана за задания</h1>

                    <a href="{{ url('/dashboard') }}" class="block my-button text-center max-w-96 my-4">НАЧАТЬ
                        СЕЙЧАС</a>
                </div>
                <p class="text-center">МЫ НИКОГДА НЕ ПОПРОСИМ ВАШ ПАРОЛЬ!</p>
            </div>

            <div class="flex flex-wrap">
                <div class="grow items-center px-2 my-4">
                    <h2 class="text-center font-semibold">Зарегистрируйтесь</h2>
                    <p class="text-center py-2">Зарегистрируйтесь, используя свое имя пользователя<br> ROBLOX или
                        учетную запись Яндекс.</p>
                    <img class="img-fluid shadow mx-auto mt-auto w-100" src="/1.png"
                        style="max-width: 349px !important; border-top-right-radius: 21px; border-top-left-radius: 21px">
                </div>
                <div class="grow items-center px-2 my-4">
                    <h2 class="text-center font-semibold">Выполняйте задания</h2>
                    <p class="text-center py-2">Выполняйте задания что бы получить Робуксы.</p>
                    <img class="img-fluid shadow mx-auto mt-auto w-100" src="/2.png"
                        style="max-width: 349px !important; border-top-right-radius: 21px; border-top-left-radius: 21px">
                </div>
                <div class="grow items-center px-2 my-4">
                    <h2 class="text-center font-semibold">Выводите Робуксы</h2>
                    <p class="text-center py-2">Перенесите свой Robux в свою учетную запись в игре ROBLOX.</p>
                    <img class="img-fluid shadow mx-auto mt-auto w-100" src="/3.png"
                        style="max-width: 349px !important; border-top-right-radius: 21px; border-top-left-radius: 21px">
                </div>

            </div>
        </div>

        <div class="footer">
            <p style="text-align: center;">&copy; 2024 LuchBux.fun - сайт где можно заработать робуксы. Все права
                защищены.<br>Мы не связаны с корпорацией ROBLOX.</p>
        </div>
    </div>

    <!-- Styles From Petr -->
    <style>
        .container {
            display: flex;
            justify-content: center;
            margin-left: 150px;

        }

        .inline {
            display: inline-block;
            margin-right: 10px;
            /* добавляем отступ между заголовками */
            width: 33%;
            box-sizing: border-box;

        }

        .my-button {
            background-color: #4CAF50;
            /* Задаем начальный цвет фона */
            color: white;
            /* Задаем цвет текста */
            padding: 40px 80px;
            /* Задаем отступы внутри кнопки */
            font-size: 24px;
            border: none;
            /* Убираем границу кнопки */
            border-radius: 5px;
            /* Задаем скругление углов кнопки */
            cursor: pointer;
            /* Задаем вид курсора при наведении на кнопку */
        }

        .my-button:hover {
            background-color: #118619;
            /* Задаем цвет фона при наведении на кнопку */
        }

        .footer {
            /* position: absolute; */
            margin-top: 2rem;
            bottom: 0;
            width: 99.5%;
            text-align: center;
            background-color: #0a5cb5;
            color: white;
        }

        /* Добавляем медиа-запрос для мобильных устройств */
        @media (max-width: 767px) {

            /* Изменяем направление flex контейнера на вертикальное */
            .container {
                flex-direction: column;
            }

            /* Устанавливаем отступы между заголовками и текстом */
            h2,
            p {
                margin-top: 10px;
                margin-bottom: 10px;
            }
        }
    </style>

</body>

</html>
