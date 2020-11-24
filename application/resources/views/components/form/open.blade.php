{{-- <x-form.open method='delete' action='delete-comment'> --}}

@props([
    'method' => 'post',
    'action' => ''
])

@php
$method = strtolower($method);
@endphp

<form method="{{ $method === 'get' ? 'get' : 'post' }}" action="{{ $action }}" {{ $attributes}}>
@if ($method != 'get')
    @csrf
@endif

@if (! in_array(strtoupper($method), ['get', 'post']))
    @method($method)
@endif

{{ $slot }}

</form>
