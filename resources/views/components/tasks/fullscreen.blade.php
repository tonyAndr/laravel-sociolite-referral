@props(['logo' => '', 'offerwall_url' => '', 'bg' => 'bg-white', 'text_color' => 'text-black'])
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <a href="{{ route('dashboard') }}"><x-primary-button type="">
                << К списку офферов</x-primary-button></a>
        <div class="{{ $bg }} overflow-hidden shadow-sm rounded-lg my-6">
            <div class="p-6">
                <div ><img src="{{ $logo }}" /></div>
                <p class="pt-4 {{$text_color}}">{{ __('Click the Start viewing button to open the ad unit. Wait until the timer ends to receive your 0.05 Robux reward. If you close the ad before the timer ends, the reward will not be awarded.') }}</p>
            </div>
        </div>
    </div>
    <div class="max-w-7xl my-10 lg:px-8 mx-auto flex flex-col content-center">
        <button id="yandex_reward_start_btn" class="start-task-btn mx-auto">Начать просмотр</button>
    </div>
</div>
