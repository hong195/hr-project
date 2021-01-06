@component('mail::message')
@if (! empty($title))
<h3 style="text-align: center;">{{ $title }}</h3>
@endif

@foreach ($introLines as $line)
<div style="text-align: center">{{ $line }}</div>
@endforeach

@isset($actionText)
@component('mail::button', ['url' => $actionUrl, 'color' => 'success'])
<div style="text-align: center;">{{ $actionText }}</div>
@endcomponent
@endisset
@endcomponent
