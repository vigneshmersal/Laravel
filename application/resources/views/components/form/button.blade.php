{{-- <x-form.button name='submit'>Submit</x-form.button> --}}

@props([
    'type' => 'submit'
])

<div>
    <button type="{{ $type }}" {{ $attributes }}>
        {{ $slot }}
    </button>
</div>
