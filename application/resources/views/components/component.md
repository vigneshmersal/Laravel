# component

Create
> php artisan make:component Card

Use
```php
<x-card src="img.png" :src="$image">
    Blade Rocks
    <x-slot name="description">Slots for the win</x-slot>
</x-card>
```

- resources/views/components/card.blade.php
```php
@props(['src'])

<div class="card">
    <img src="{{ $src }}">
    <h2>{{ $slot }}</h2>
    <p>{{ $description }}</p>
</div>
```

Pass All attributes
```php
<x-card class="card bg-white"></x-card>

<div {{ $attributes }}></div>
```

Merge attribute values to existing attribute
```php
<x-card class="bg-white"></x-card>

<div {{ $attributes->merge(['class' => 'card']) }}>
```
