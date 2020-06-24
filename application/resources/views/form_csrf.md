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

$('#form').submit(function(e) {
    e.preventDefault();
    var setdata = $('#form').serialize();
    $.ajax({
        url: 'actions/checklogin.php',
        type: 'POST',
        data: setdata,
        error: function () { },
        success: function (data) { }
    });
});
```

# Form
```php
<form action="/action_page.php" target="_blank" method="post">

{!! Form::open([
	'url' => 'foo/bar',
	'route' => ['route.name', $user->id],
	'action' => ['Controller@method', $user->id],
	'method' => 'post',
	'class' => '',
	'accept-charset' => 'UTF-8',
	'files' => true,
]) !!}

    {!! Form::token() !!}

    {!! Form::label($for="email", $text="EMail", []) !!}

    {!! Form::text($name, $value, []) !!}
    {!! Form::textarea($name, $value, []) !!}

    {!! Form::select($name, $optionsArray, $defaultKey, []) !!}
    {!! Form::selectMonth($name, []) !!}
    {!! Form::selectRange($name, $min, $max, []) !!}

    {!! Form::email($name, $value, []) !!}

    {!! Form::file($name, []) !!}

    {!! Form::number($name, $value, []) !!}

    {!! Form::date($name, \Illuminate\Support\Carbon::now(), []) !!}

    {!! Form::checkbox($name, $value, $checked=true, []) !!}
    {!! Form::radio($name, $value, $checked=true, []) !!}

    {!! Form::submit($text="Submit", []) !!}

{!! Form::close() !!}
```
