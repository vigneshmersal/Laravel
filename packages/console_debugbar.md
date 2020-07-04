# Debugbar
[laravel-debugbar](https://github.com/barryvdh/laravel-debugbar)

## Install
> composer require barryvdh/laravel-debugbar --dev

> php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"

## Use
At `Messages` tab,
```php
Debugbar::info($object);
Debugbar::error('Error!');
Debugbar::warning('Watch out…');
Debugbar::addMessage('Another message', 'mylabel');
```

And start/stop timing:
```php
Debugbar::startMeasure('render','Time for rendering');
Debugbar::stopMeasure('render');
Debugbar::addMeasure('now', LARAVEL_START, microtime(true));
Debugbar::measure('My long operation', function() {
    // Do something…
});
```

Log
```php
try {
    throw new Exception('foobar');
} catch (Exception $e) {
    Debugbar::addThrowable($e);
}
```

## Specifications
- QueryCollector
- EventsCollector
- LogsCollector
- SwiftMailCollector
- ExceptionsCollector
