@component('mail::message')
<p>
Появилась новая заявка на вывод.
</p>

<ul>
    <li>ID: {{$withdrawal->id}}</li>
    <li>Robux: {{$withdrawal->robux}}</li>
    <li>GamePass: {{$withdrawal->gamepass_url}}</li>
    <li>USER ID: {{$withdrawal->user_id}}</li>
    <li>Created at: {{$withdrawal->created_at}}</li>
</ul>

@component('mail::button', ['url' => route('admin.index')])
В админку
@endcomponent

Cheers,<br>
{{ config('app.name') }}
@endcomponent