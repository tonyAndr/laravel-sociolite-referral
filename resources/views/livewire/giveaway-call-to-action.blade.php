<div class="flex flex-col items-center" id="tg_sub_check_component">
    @if (!$user_is_participating)
        <div class="flex flex-col items-center">
            <a href="{{ route('giveaway.quiz', ['step' => 1]) }}"
                class="block home-main-action-btn text-center max-w-96 mb-4">УЧАСТВОВАТЬ В
                РАЗДАЧЕ</a>
        </div>
    @endif
    @if (!$user_subscribed)
        <div class="flex flex-col items-center">
            <p>Победить могут только подписчики канала!</p>
            <a href="{{ route('giveaway.quiz', ['step' => 2]) }}"
                class="block join-channel-btn text-center max-w-96 mb-4">Подпишись на Luchbux.Fun</a>
        </div>
    @endif
</div>

@script
    <script>
        let checker = setInterval(function() {

            $wire.dispatch('intervalSubscriptionCheck');

        }, 5000)
    </script>
@endscript
