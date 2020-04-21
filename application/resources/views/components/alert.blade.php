@props(['type' => 'info', 'message']) {{-- Anonymous Components Data --}}

{{ $attributes }}

{{ $attributes->merge(['class' => 'alert alert-'.$type]) }}

<div class="alert alert-{{ $alertType }}">
    {{ $message }}
</div>
