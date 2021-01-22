@component('mail::message')
@if (! empty($title))
<h3 style="text-align: center;">{{ $title }}</h3>
@endif

@foreach ($introLines as $line)
<div>{{ $line }}</div>
@endforeach
<br/>
<div><strong>Электронная почта: </strong>{{ $email }}</div>
<div><strong>Пароль: </strong>{{ $password }}</div>
@endcomponent
<br/>
