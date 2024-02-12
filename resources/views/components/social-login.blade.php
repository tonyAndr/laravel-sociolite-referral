    <!-- Using socialite -->
<div class="flex flex-col justify-center">
    <p class="text-xl pb-4 text-center">Вход через соцсети</p>
    <div class="flex justify-center mb-4">{!! Socialite::driver('telegram')->getButton() !!}</div>
    <div class="columns-4 grow mb-6">
        <a class="block text-center" href="{{ route('oauth.redirect', 'yandex') }}">
            <i class="fa-brands fa-yandex text-3xl"></i>
        </a>
        <a class="block  text-center" href="{{ route('oauth.redirect', 'google') }}">
            <i class="fa-brands fa-google text-3xl"></i>
        </a>
        <a class="block text-center" href="{{ route('oauth.redirect', 'vkontakte') }}">
            <i class="fa-brands fa-vk text-3xl"></i>
        </a>
        <a class="block text-center" href="{{ route('oauth.redirect', 'tiktok') }}">
            <i class="fa-brands fa-tiktok text-3xl"></i>
        </a>
    </div>
    <hr class="mb-6">
</div>