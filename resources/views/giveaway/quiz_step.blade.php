@extends('layouts.public')

@section('title', 'Раздача')
@section('description', 'Page desc')

@section('content')
    <input id='countdown_time' hidden type='number' value='{{ $countdown_time }}' />
    @include("giveaway.step$step")
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

@endsection
