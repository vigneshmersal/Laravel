# log
https://github.com/rap2hpoutre/laravel-log-viewer

```php
Log::emergency($message);
Log::alert($message);
Log::critical($message);
Log::error($message);
Log::warning($message);
Log::notice($message);
Log::info($message);
Log::debug($message);
```

## Example
```php
Log::debug('An informational message.');
Log::emergency('The system is down!');
Log::info('User failed to login.', ['id' => $user->id]);

# channel
Log::channel('slack')->info('Something happened!');
Log::stack(['single', 'slack'])->info('Something happened!');
```
