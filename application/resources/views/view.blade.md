# Blade

## structure
```php
# Default view
@yield('content', View::make('view.name'))
# Use
@section('title', 'Page Title')
@section('content')
	<p>This is my body content.</p>
@endsection

if (view()->exists('custom.page')) { }
# if page1 blade not exist, dashboard will be loaded
return view()->first(['page1', 'dashboard'], $data);
```

### Extend section
```php
# Define
@section('sidebar')
	This is the extend section.
@show
# Use
@section('sidebar')
	@parent
	<p>This is appended to the master sidebar.</p>
@endsection
```

## diplay
```php
{{ $var }}
{{ time() }} // display timestamp
{!! $name !!} // Displaying Unescaped Data (htmlspecialchars)

{{-- display command --}} // command

@php
@endphp

# Remove from Vue js
@{{ @name }}
@verbatim
	{{ @name }}
@endverbatim

# ternary operator
{{ $var ?: null }} -> {{ $var ? $var : null }}

# isset condition
{{ $var ?? null }}  -> {{ isset($var) ? $var : null }}
{{ $name or 'Guest' }} -> {{ isset($var) ? $var : null }}

# Initialize class in blade file
@inject('metrics', 'App\Services\MetricsService')
{{ $metrics->monthlyRevenue() }}
```

## include
```php
# inherit all data available in the parent view & pass extra data
@include('view.name', ['some' => 'data'])
@includeIf('view.name', ['some' => 'data'])
@includeWhen($boolean, 'view.name', ['some' => 'data'])
@includeUnless($boolean, 'view.name', ['some' => 'data'])
@includeFirst(['custom.admin', 'admin'], ['some' => 'data']) // include if exists

# AppServiceProvider - shorten path
Blade::include('includes.input', 'input'); // @input(['type' => 'email'])

# Combine loops & includes
@each('view.path', $collection = $jobs, $each = 'job')
@each('view.name', $jobs, 'job', 'view.empty') // if the array collection empty call view.empty
```

## Components (kebab case)
```php
# Use
<x-alert> // resources/views/components/inputs/button.blade.php
<x-user-profile/>
<x-inputs.button/> // path -> App\View\Components\Inputs\Button.php

# Passing data
<x-alert alert-type="error" :message="$message" class="mt-4" />

# Get attribute bag is automatically available to the component by $attributes variable
{{ $attributes }}

# specify default values or merge additional values
{{ $attributes->merge(['class' => 'alert alert-'.$type]) }}

# pass additional content via slot
<x-alert>
    <x-slot name="title"> // {{ $title }}
        Server Error
    </x-slot>

    <strong>Whoops!</strong> Something went wrong! // {{ $slot }}
</x-alert>

# Anonymous Components - Data
@props(['type' => 'info', 'message'])
```

## script

```php
// array
var app = <?php echo json_encode($array); ?>;
var app = @json($array);
var app = @json($array, JSON_PRETTY_PRINT);

@stack('scripts') // define
@prepend('scripts')
@endprepend
@push('scripts') // use
@endpush
```

___

## Vue

```php
<example-component :some-prop='@json($array)'></example-component>
```

## Validation error
```php
{{ old('username') }}

# attach error class if
<input id="title" type="text" class="@error('title') is-invalid @enderror">

# display if any errors
@error('title')
	<div class="alert alert-danger">{{ $message }}</div>
@enderror

# display nemed error fields
<input id="email" type="email" class="@error('email', 'login') is-invalid @enderror">
{{ $errors->login->first('email') }}

# Retrive first error
$errors->first('email');

# Retrieving All Error Messages
foreach ($errors->get('email') as $message) { }
foreach ($errors->get('attachments.*') as $message) { }
foreach ($errors->all() as $message) { }

# check
if ($errors->has('email')) { }
@if ($errors->any())
@error('title')
```
## Condition

```php
true - collect()
false - 0, '', null, []
# if
@if($condition)
@elseif($condition)
@else
@endif

# Check section present in layout
@hasSection('navigation')
@endif

# unless
@unless($condition)
@endunless

# isset
true - 0, '', [], collect()
false - null,
@isset($condition)
@endisset

# empty
true - 0, '', null, []
false - collect()
@empty($condition)
@endempty

# authenticated
@auth
@endauth

@auth('admin')
@endauth

# Not authenticated
@guest
@endguest

@guest('admin')
@endguest
```

## AppServiceProvider
```php
# shorten path
Blade::include('includes.input', 'input'); // @input(['type' => 'email'])

# Extending blade  -> @datetime($var)
Blade::directive('datetime', function ($expression) {
    return "<?php echo ($expression)->format('m/d/Y H:i'); ?>";
});

# Custom if statement -> @env('local') @elseenv('testing') @endenv
Blade::if('env', function ($environment) {
    return app()->environment($environment);
});
# Use it by
@env('local')
    // The application is in the local environment...
@elseenv('testing')
    // The application is in the testing environment...
@else
    // The application is not in the local or testing environment...
@endenv

@unlessenv('production')
    // The application is not in the production environment...
@endenv
```

## permission
```php
@can([])
@canany([])
@if(Gate::check('permission1') || Gate::check('permission2'))
@if(auth()->user()->hasAnyPermission(['permission1','permission2']))
```


