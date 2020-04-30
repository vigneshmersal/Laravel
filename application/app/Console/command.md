# Command

## call
```php
Artisan::call('email:send', ['user' => 1, '--queue' => 'default', '--id' => [5], '--force' => true ]);
Artisan::call('email:send', ['user' => 1, '--queue' => 'default']);
Artisan::queue('email:send 1 --queue=default'); // queue
```

## Arguments
```php
{user}
{user?} // optional
{user=foo} // pass value
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

## Progress Bars
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
