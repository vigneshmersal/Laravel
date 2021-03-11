# Command
https://quantizd.com/how-to-use-laravel-task-scheduler-on-windows-10/
https://ole.michelsen.dk/blog/schedule-jobs-with-crontab-on-mac-osx/

> php artisan schedule:list

open cron file
> crontab -e
> env EDITOR=vim crontab -e

list crons
> crontab -l

command
> * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
// or
> * * * * * php /var/www/console.guidely.in/htdocs/artisan schedule:run >> /dev/null 2>&1

local
> php artisan schedule:run

## call
```php
Artisan::call('email:send', ['user' => 1, '--queue' => 'default', '--id' => [5], '--force' => true ]);
Artisan::call('email:send', ['user' => 1, '--queue' => 'default']);
Artisan::queue('email:send 1 --queue=default'); // queue
	->onConnection('redis')->onQueue('commands');
```

## Arguments
```php
{user}
{user=} // required
{user?} // optional
{user=foo} // default value
{user: description} // description
```

## Options
```php
{--queue} // value - true
{--queue=default}
{--queue=custom}
{--Q|queue} // shortcut
{id*} // array: 1 2
{--id=*} // --id=1 --id=2
{--queue= : description}
```

## schedule
```php
->everyMinute(); // 1 min
->everyTwoMinutes(); // 2 min
->everyThreeMinutes(); // 3 min
->everyFourMinutes(); // 4 min
->everyFiveMinutes(); // 5 min
->everyTenMinutes(); // 10 min
->everyFifteenMinutes(); // 15 min
->everyThirtyMinutes();	// 30 min
->hourly();	// 1 hr
->everyTwoHours();	// 2 hr
->everyThreeHours(); // 3 hr
->everyFourHours();	// 4 hr
->everySixHours();	// 6 hr
->daily();
->dailyAt('13:00');
->twiceDaily(1, 13);
->weekly();
->weeklyOn(1, '8:00');
->monthly();
->monthlyOn(4, '15:00');
->lastDayOfMonth('15:00');
->quarterly();
->yearly();
->timezone('America/New_York');

// particular
->weekly()->mondays()->at('13:00');

// days
->weekdays();
->weekends();
->sundays();
->mondays();
->tuesdays();
->wednesdays();
->thursdays();
->fridays();
->saturdays();

// interval
->days([0, 3]);
->days([1,2,3,4,5,6])->at('8:00');
->days(range(1,6))->at('8:00');
->between('7:00', '22:00');
->unlessBetween('23:00', '4:00');

// condition
->environments($env); ->environments(['staging', 'production']);
->when(Closure);
->skip(function () {});

// time zone
->timezone('America/New_York')

// time
->at('02:00')

// run at same time
->withoutOverlapping(); // prevent to run if previous job is run
->withoutOverlapping(10); // default 24hr
->runInBackground();
->evenInMaintenanceMode();

// output
->sendOutputTo($filePath);
->appendOutputTo($filePath);
->emailOutputTo('foo@example.com');
->emailOutputOnFailure('foo@example.com');

// before , after
->before(function () { }) , ->after(function () { });

// success | fail
->onSuccess(function () { }) , ->onFailure(function () { });

// ping url
->pingBefore($url) , ->thenPing($url);
->pingBeforeIf($condition, $url) , ->thenPingIf($condition, $url);
->pingOnSuccess($successUrl) , ->pingOnFailure($failureUrl);
```

## Handle
```php
# Retrive Arguments
$this->argument('user');
$this->arguments(); // retrieve all of the arguments as an array

# Retrive Options
$this->option('queue');
$this->options();

$name = $this->ask('What is your name?'); // ask
$password = $this->secret('What is the password?'); // ask sensitive information

$this->info('display green txt');
$this->error('display error red txt');
$this->line('display uncolor txt');
$this->comment('');
$this->question('');

$this->table($headers = ['name'], $users = User::all([]));

if ($this->confirm('Do you wish to continue?')) { }

# Auto-completion
$name = $this->anticipate('What is your name?', ['Taylor', 'Dayle']);
$name = $this->anticipate('What is your name?', function ($input) {
    // Return auto-completion options...
});

# Choice
$name = $this->choice('What is your name?', ['Taylor', 'Dayle'], $defaultIndex = 0);
$name = $this->choice($question,[$choices],$default,$maxAttempts = null,$allowMultipleSelections = false);
```

## Console Progress Bars
```php
$users = App\User::all();
$bar = $this->output->createProgressBar(count($users));
$bar->start();
foreach ($users as $user) {
    $this->performTask($user);
    $bar->advance();
}
$bar->finish();
```
