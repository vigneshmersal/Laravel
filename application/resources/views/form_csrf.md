# CSRF
Setup AJAX csrf-token header
```js
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
```

```php
@csrf
@method("PUT")

<input type="hidden" name="_method" value="PUT">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
```

# Form
```php
{!! Form::open([
	'url' => '',
	'route' => '',
	'action' => '',
	'method' => 'post',
	'class' => '',
	'accept-charset' => 'UTF-8',
]) !!}




{!! Form::close() !!}
```
