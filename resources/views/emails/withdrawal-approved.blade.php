@component('mail::message')
<p>
Привет! Заявка на вывод робуксов была выполнена. Проверь свой баланс в роблоксе! 
</p>

@if($comment)
<p>Комментарий: {{ $comment }}</p>
@endif

@component('mail::button', ['url' => route('withdrawal.index')])
Мои заявки
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent