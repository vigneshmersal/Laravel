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
// (or)
<input type="hidden" name="_method" value="PUT">
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<span onclick="event.preventDefault();
    if(confirm('Are you really want to delete?')){
        document.getElementById('id').submit()
    }
">click</span>
```

# Form
```php
{!! Form::open([
	'url' => 'foo/bar',
	'route' => ['route.name', $user->id],
	'action' => ['Controller@method', $user->id],
	'method' => 'post',
	'class' => '',
	'accept-charset' => 'UTF-8',
	'files' => true,
]) !!}

	Form::token();

    Form::label('email', 'E-Mail', $attributes[]);

    Form::text($name, $value, $attributes[] );

    Form::select($name, $options, $default, $attributes[] );
    Form::selectRange('number', 10, 20);
    Form::selectMonth('month');

    Form::email($name, $value, $attributes[]);

    Form::file($name, $attributes[]);

    Form::number($name, $value);

    Form::date($name, $value);

    Form::checkbox($name, $value, true);
    Form::radio($name, $value, true);

    Form::submit('Click');

{!! Form::close() !!}
```
