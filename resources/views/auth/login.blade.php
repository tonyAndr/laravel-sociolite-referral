@extends('layouts.public')

@section('title', 'LuchBux.Fun - Вход в аккаунт')
@section('description', 'Войди для получения бесплатных робуксов')

@section('content')

    <div class="min-h-screen flex flex-col items-center pt-6 bg-gray-100 bark:bg-gray-900">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white bark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <p>Авторизуйся для получения бесплатных робуксов</p>
                <x-social-login />
        </div>
    </div>

@endsection
