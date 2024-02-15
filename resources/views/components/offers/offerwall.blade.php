@props(['logo' => '', 'offerwall_url' => '', 'bg' => 'bg-white', 'text_color' => 'text-black'])
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <a href="{{ route('dashboard') }}"><x-primary-button type="">
                << К списку офферов</x-primary-button></a>
        <div class="{{ $bg }} overflow-hidden shadow-sm rounded-lg my-6">
            <div class="p-6">
                <div ><img src="{{ $logo }}" /></div>
                <p class="pt-4 {{$text_color}}">{{ __('Complete any offer from the offerwall below to get robux!') }}</p>
            </div>
        </div>
    </div>
    <div class="max-w-7xl my-10 lg:px-8 mx-auto flex flex-col flex-wrap content-stretch">
        <iframe class="min-w-full " style="height:690px; border:none;" frameborder="0"
            src="{!! $offerwall_url !!}"></iframe>
    </div>
</div>
