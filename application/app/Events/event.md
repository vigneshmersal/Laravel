# Event
> php artisan make:event EventName

## Fire Event
```php
\Event::fire( new EventName($dataOne, $dataTwo))
// Or calling the global function everywhere in the app
event(new EventName($dataOne, $dataTwo))
```

# Listener
> php artisan make:listener FirstListener --event=EventName

```php
protected $listen = [
    'App\Events\EventName' => [
        'App\Listeners\FirstListener',
        'App\Listeners\SecondListener',
    ],
];
```
