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
    'style' => '',
]) !!}

    {!! Form::token() !!}

    {!! Form::label($for="email", $text="EMail", []) !!}

    {!! Form::text($name, $value, []) !!}
    {!! Form::text('name', old('name', $user->name ?? null), [
        'class' => 'form-control',
        'required' => true
    ]) !!}

    {!! Form::textarea($name, $value, []) !!}
    {!! Form::textarea('address', old('address', $user->address ?? null), [
        'class' => 'form-control',
        'rows' => 5, 'cols' => 5
    ]) !!}

    {!! Form::select($name, $optionsArray, $defaultKey, []) !!}
    {{ Form::select('employee_team', [
            '1'=>'Product Making Team',
        ], old('employee_team', $user->employee_team ?? null), [
            'class'=>'form-control',
            'required'=>true
        ])
    }}
    # Multiple select
    {{ Form::select('user_rights[]', [
            '1'=>'All',
        ], old('user_rights[]', explode(",", $user->user_rights ?? null)), [
            'class' => 'js-example-basic-multiple col-sm-12',
            'required' => true,
            'multiple' => true
        ])
    }}

    {!! Form::selectMonth($name, []) !!}
    {!! Form::selectRange($name, $min, $max, []) !!}

    {!! Form::email($name, $value, []) !!}
    {!! Form::email('email', old('email', $user->email ?? null), [
        'class' => 'form-control',
        'required' => true
    ]) !!}

    {!! Form::password($name, []) !!}
    {!! Form::password('password', [
        'class' => 'form-control',
        'required' => isset($user) ? false : true
    ]) !!}

    {!! Form::file($name, []) !!}
    {!! Form::file('profile_image', [ 'class' => 'form-control' ]) !!}
    @if($candidate->profile_image != "")
        <br><img class="img-fluid" width="200" height="200" src="{{ asset('img/'.$user->image) }}" alt="User profile">
    @endif

    {!! Form::number($name, $value, []) !!}

    {!! Form::date($name, \Illuminate\Support\Carbon::now(), []) !!}
    {!! Form::date('dob', old('dob', $user->dob ?? null), [
        'class' => 'form-control',
        'required' => true
    ]) !!}

    {!! Form::checkbox($name, $value, $checked=true, []) !!}
    {!! Form::radio($name, $value, $checked=true, []) !!}

    {!! Form::submit($text="Submit", []) !!}
    {!! Form::submit('Save', [ 'class' => 'btn btn-success' ]) !!}

{!! Form::close() !!}
```
