# [Localization](https://laravel.com/docs/7.x/localization)
Location: `resources/lang`

Set default language in `config/app.php`
> 'fallback_locale' => 'en',

```php
# Set locale
App::setLocale($locale);

# Get locale
$locale = App::getLocale();

# Check Locale
if (App::isLocale('en')) { }

# Retrive translation word in a blade
{{ __('messages.welcome') }}// call by file.key
{{ __('I love programming.') }} // call by word
@lang('messages.welcome')

# Using Placeholder
[ 'welcome' => 'Welcome, :name' ] // Result: Welcome dayle
[ 'welcome' => 'Welcome, :NAME' ] // capitalized Result: Welcome DAYLE
[ 'welcome' => 'Welcome, :Name' ] // capitalized Result: Welcome Dayle
{{ __('messages.welcome', ['name' => 'dayle']) }}

# Pluralization
[ 'apples' => 'There is one apple|There are many apples' ] // singular | Plural
```

## Route
```php
Route::get('welcome/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'es', 'fr'])) {
        abort(400);
    }

    App::setLocale($locale);
});
```
