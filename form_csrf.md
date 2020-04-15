# CSRF
Setup AJAX csrf-token header
```js
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
```

# Form
```php
<form method="POST" action="/profile">
    @csrf
    @method("PUT")
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

</form>
```
