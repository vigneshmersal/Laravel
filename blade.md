# Blade

## diplay
```php
{{ $var }}

// ternary operator
{{ $var ?: null }} -> {{ $var ? $var : null }}

// isset condition
{{ $var ?? null }}  -> {{ isset($var) ? $var : null }}
{{ $name or 'Guest' }} -> {{ isset($var) ? $var : null }}
```

## looping
```php
@foreach ($users as $each)
	{{ $loop->index + $users->firstItem() }} // row id -> index(0) + modal
@endforeach
```
