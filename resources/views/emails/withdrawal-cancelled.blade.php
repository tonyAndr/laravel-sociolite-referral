@component('mail::message')
<p>
Привет! Заявка на вывод робуксов была отменена. Причина: {{ $reason }}
</p>

@component('mail::button', ['url' => route('withdrawals.index')])
Пересоздать заявку
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent