@component('mail::message')
# {{ $sender->name }} has invited you

You will get 70% discount.

@component('mail::button', ['url' => route('register', ['referral' => $referral->token])])
Sign up
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent