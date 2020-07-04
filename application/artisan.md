# Terminal
See env file
> env
___
# php artisan
Options:
> -V, --version `Display this application version`

Artisan command,
> Artisan::call('migrate');

## Table
> cache:table `Create a migration for the cache database table`

> notifications:table `Create a migration for the notifications table`

> session:table `Create a migration for the session database table`

> queue:table `Create a migration for the queue jobs database table`

## Commands:
> clear-compiled `Remove the compiled class file`

> down `Put the application into maintenance mode`
  _--message[=MESSAGE]_ `The message for the maintenance mode`
  _--retry[=RETRY]_ `The number of seconds after which the request may be retried`
  _--allow[=ALLOW]_ `IP or networks allowed to access the application while in maintenance mode (multiple values allowed`

> env `Display the current framework environment` _local or production_

> help `Displays help for a command`

> inspire `Display an inspiring quote`

> list `Lists commands`
  _raw_ `raw format list`
  _test_ `display the commands for a specific namespace`
  _--format=xml,txt,json,md_ `Change output information formats in terminal`

> migrate `Run the database migrations`
  _--database[=DATABASE]_ `The database connection to use`
  _--force_ `Force the operation to run when in production`
  _--path[=PATH]_ `The path(s) to the migrations files to be executed (multiple values allowed)`
  _--realpath_ `Indicate any provided migration file paths are pre-resolved absolute paths`
  _--pretend_ `Dump the SQL queries that would be run`
  _--seed_ `Indicates if the seed task should be re-run`
  _--step_ `Force the migrations to be run so they can be rolled back individually`

> optimize `Cache the framework bootstrap files`

> serve `Serve the application on the PHP development server`
  _--host[=HOST]_ `The host address to serve the application on [default: "127.0.0.1"]`
  _--port[=PORT]_ `The port to serve the application on`
  _--tries[=TRIES]_ `The max number of ports to attempt to serve from [default: 10]`

> test `Run the application tests`
  _--without-tty_ `Disable output to TTY`

> tinker `Interact with your application`
  _[<include>]_ `Include file(s) before starting tinker`
  _--execute[=EXECUTE]_ `Execute the given code using Tinker`

> up `Bring the application out of maintenance mode`

___
## auth
> auth:clear-resets `Flush expired password reset tokens`
  _[<name>]_ `The name of the password broker`

## cache
> cache:clear `Flush the application cache`
  _[<store>]_ `The name of the store you would like to clear`
  _--tags[=TAGS]_ `The cache tags you would like to clear`

> cache:forget `Remove an item from the cache`
  _[<key>]_ `The key to remove`
  _[<store>]_ `The store to remove the key from`

## command
> command:name `Command description`

## config
> config:cache `Create a cache file for faster configuration loading`

> config:clear `Remove the configuration cache file`

## db
> db:seed `Seed the database with records`
- ex: db:seed --class=UsersTableSeeder
 _--class[=CLASS]_ `The class name of the root seeder [default: "DatabaseSeeder"]`
 _--database[=DATABASE]_ `The database connection to seed`
 _--force_ `Force the operation to run when in production`

> db:wipe `Drop all tables, views, and types`
 _--database[=DATABASE]_ `The database connection to use`
 _--drop-views_ `Drop all tables and views`
 _--drop-types_ `Drop all tables and types (Postgres only)`
 _--force_  `Force the operation to run when in production`

## event
> event:cache `Discover and cache the application's events and listeners`

> event:clear `Clear all cached events and listeners`

> event:generate `Generate the missing events and listeners based on registration`

> event:list `List the application's events and listeners`
 _--event[=EVENT]_ `Filter the events by name`

## key
> key:generate `Set the application key`
 _--show_ `Display the key instead of modifying files`
 _--force_ `Force the operation to run when in production`

## make
> make:channel `Create a new channel class`
 _[<name>]_ `The name of the class`

> make:command *SendEmails* `Create a new Artisan command`
 _[<name>]_ `The name of the command`

> make:component *Alert* `Create a new view component class`
 _[<name>]_ `The name of the component`
 _--force_ `Create the class even if the component already exists`
 _--inline_ `Create a component that renders an inline view`

> make:controller `Create a new controller class`
- ex: make:controller Api/PhotosApiController -r -m=Photo --api
 _[<name>]_ `The name of the controller`
 _--api_ `Exclude the create and edit methods from the controller`
 _--force_ `Create the class even if the controller already exists.`
 _-i, --invokable_ `Generate a single method, invokable controller class.`
 _-m, --model[=MODEL]_ `Generate a resource controller for the given model.`
 _-p, --parent[=PARENT]_ `Generate a nested resource controller class.`
 _-r, --resource_ `Generate a resource controller class.`

> make:event `Create a new event class`
 _[<name>]_ `The name of the class`

> make:exception `Create a new custom exception class`
 _[<name>]_ `The name of the class`
 _--render_ `Create the exception with an empty render method`
 _--report_ `Create the exception with an empty report method`

> make:factory `Create a new model factory`
- ex: make:factory --model User Post
 _[<name>]_ `The name of the class`
 _-m, --model[=MODEL]_ `The name of the model`

> make:job `Create a new job class`
 _[<name>]_ `The name of the class`
 _--sync_ `Indicates that job should be synchronous`

> make:listener `Create a new event listener class`
 _[<name>]_ `The name of the class`
 _-e, --event[=EVENT]_ `The event class being listened for`
 _--queued_ `Indicates the event listener should be queued`

> make:mail `Create a new email class`
 _[<name>]_ `The name of the class`
 _-f, --force_ `Create the class even if the mailable already exists`
 _-m, --markdown[=MARKDOWN]_ `Create a new Markdown template for the mailable`

> make:middleware *CheckAge* `Create a new middleware class`
 _[<name>]_ `The name of the class`

> make:migration *create_users_table, remove_user_id_from_posts_table* `Create a new migration file`
 _[<name>]_ `The name of the migration`
 _--create[=CREATE]_ `The table to be created`
 _--table[=TABLE]_ `The table to migrate`
 _--path[=PATH]_ `The location where the migration file should be created`
 _--realpath_ `Indicate any provided migration file paths are pre-resolved absolute paths`
 _--fullpath_ `Output the full path of the migration`

> make:model *User* `Create a new Eloquent model class`
 _[<name>]_ `The name of the class`
 -a, --all             Generate a migration, seeder, factory, and resource controller for the model
 -c, --controller      Create a new controller for the model
 -f, --factory         Create a new factory for the model
     --force           Create the class even if the model already exists
 -m, --migration       Create a new migration file for the model
 -s, --seed            Create a new seeder file for the model
 -p, --pivot           Indicates if the generated model should be a custom intermediate table model
 -r, --resource        Indicates if the generated controller should be a resource controller
     --api             Indicates if the generated controller should be an API controller

> make:notification `Create a new notification class`
>> _[<name>]_ 				  The name of the class
>> -f, --force                Create the class even if the notification already exists
>> -m, --markdown[=MARKDOWN]  Create a new Markdown template for the notification

> make:observer `Create a new observer class`
 _[<name>]_ 		   `The name of the class`
 -m, --model[=MODEL]   The model that the observer applies to.

> make:policy *PostPolicy* `Create a new policy class`
 _[<name>]_ 		   `The name of the class`
 -m, --model[=MODEL]   The model that the policy applies to

> make:provider `Create a new service provider class`
 _[<name>]_ 			`The name of the class`

> make:request *PackageRequest* `Create a new form request class`
 _[<name>]_ 			`The name of the class`

> make:resource `Create a new resource`
 _[<name>]_ 			`The name of the class`
   -c, --collection      Create a resource collection

> make:rule *Uppercase* `Create a new validation rule`
 _[<name>]_ 			`The name of the class`

> make:seeder `Create a new seeder class`
 _[<name>]_ 			`The name of the class`

> make:test `Create a new test class`
 _[<name>]_ 			`The name of the class`
  --unit            	Create a unit test

## migrate
> migrate:fresh `Drop all tables and re-run all migrations`
  --database[=DATABASE]  The database connection to use
  --drop-views           Drop all tables and views
  --drop-types           Drop all tables and types (Postgres only)
  --force                Force the operation to run when in production
  --path[=PATH]          The path(s) to the migrations files to be executed (multiple values allowed)
  --realpath             Indicate any provided migration file paths are pre-resolved absolute paths
  --seed                 Indicates if the seed task should be re-run
  --seeder[=SEEDER]      The class name of the root seeder
  --step                 Force the migrations to be run so they can be rolled back individually

> migrate:install `Create the migration repository`
  --database[=DATABASE]  The database connection to use

> migrate:refresh `Reset and re-run all migrations`
  --database[=DATABASE]  The database connection to use
  --force                Force the operation to run when in production
  --path[=PATH]          The path(s) to the migrations files to be executed (multiple values allowed)
  --realpath             Indicate any provided migration file paths are pre-resolved absolute paths
  --seed                 Indicates if the seed task should be re-run
  --seeder[=SEEDER]      The class name of the root seeder
  --step[=STEP]          The number of migrations to be reverted & re-run

> migrate:reset `Rollback all database migrations`
 --database[=DATABASE]  The database connection to use
  --force                Force the operation to run when in production
  --path[=PATH]          The path(s) to the migrations files to be executed (multiple values allowed)
  --realpath             Indicate any provided migration file paths are pre-resolved absolute paths
  --pretend              Dump the SQL queries that would be run

> migrate:rollback `Rollback the last database migration`
 --database[=DATABASE]  The database connection to use
  --force                Force the operation to run when in production
  --path[=PATH]          The path(s) to the migrations files to be executed (multiple values allowed)
  --realpath             Indicate any provided migration file paths are pre-resolved absolute paths
  --pretend              Dump the SQL queries that would be run
  --step[=STEP]          The number of migrations to be reverted

> migrate:status `Show the status of each migration`
--database[=DATABASE]  The database connection to use
  --path[=PATH]          The path(s) to the migrations files to use (multiple values allowed)
  --realpath             Indicate any provided migration file paths are pre-resolved absolute paths

## optimize
> optimize:clear `Remove the cached bootstrap files`

## package
> package:discover `Rebuild the cached package manifest`

## queue
> queue:failed `List all of the failed queue jobs`

> queue:failed-table `Create a migration for the failed queue jobs database table`

> queue:flush `Flush all of the failed queue jobs`

> queue:forget `Delete a failed queue job`
 _[<id>]_ `The ID of the failed job`

> queue:listen `Listen to a given queue`
 _[<connection>]_ `The name of connection`
  --delay[=DELAY]      The number of seconds to delay failed jobs [default: "0"]
  --force              Force the worker to run even in maintenance mode
  --memory[=MEMORY]    The memory limit in megabytes [default: "128"]
  --queue[=QUEUE]      The queue to listen on
  --sleep[=SLEEP]      Number of seconds to sleep when no job is available [default: "3"]
  --timeout[=TIMEOUT]  The number of seconds a child process can run [default: "60"]
  --tries[=TRIES]      Number of times to attempt a job before logging it failed [default: "1"]

> queue:restart `Restart queue worker daemons after their current job`

> queue:retry `Retry a failed queue job`
 _[<id>]_ `The ID of the failed job or "all" to retry all jobs`

> queue:work `Start processing jobs on the queue as a daemon`
 _[<connection>]_ `The name of the queue connection to work`
 --queue[=QUEUE]      The names of the queues to work
--daemon             Run the worker in daemon mode (Deprecated)
--once               Only process the next job on the queue
--stop-when-empty    Stop when the queue is empty
--delay[=DELAY]      The number of seconds to delay failed jobs [default: "0"]
--force              Force the worker to run even in maintenance mode
--memory[=MEMORY]    The memory limit in megabytes [default: "128"]
--sleep[=SLEEP]      Number of seconds to sleep when no job is available [default: "3"]
--timeout[=TIMEOUT]  The number of seconds a child process can run [default: "60"]
--tries[=TRIES]      Number of times to attempt a job before logging it failed [default: "1"]

## route
> route:cache `Create a route cache file for faster route registration`

> route:clear `Remove the route cache file`

> route:list `List all registered routes`
 --columns[=COLUMNS]  Columns to include in the route table (multiple values allowed)
  -c, --compact            Only show method, URI and action columns
      --json               Output the route list as JSON
      --method[=METHOD]    Filter the routes by method
      --name[=NAME]        Filter the routes by name
      --path[=PATH]        Filter the routes by path
  -r, --reverse            Reverse the ordering of the routes
      --sort[=SORT]        The column (domain, method, uri, name, action, middleware) to sort by [default: "uri"]

## schedule
> schedule:run `Run the scheduled commands`

## storage
> storage:link `Create the symbolic links configured for the application`
      --relative        Create the symbolic link using relative paths

## stub
> stub:publish `Publish all stubs that are available for customization`
      --force           Overwrite any existing files

## ui
> ui `Swap the front-end scaffolding for the application`
>> bootstrap --auth
>>  vue --auth
>> react --auth
 --auth             Install authentication UI scaffolding
 --option[=OPTION]  Pass an option to the preset command (multiple values allowed)

> ui:auth `Scaffold basic login and registration views and routes`
 --views           Only scaffold the authentication views
  --force           Overwrite existing views by default

> ui:controllers `Scaffold the authentication controllers`

## vendor
> vendor:publish `Publish any publishable assets from vendor packages`
 --force                Overwrite any existing files
  --all                  Publish assets for all service providers without prompt
  --provider[=PROVIDER]  The service provider that has assets you want to publish
  --tag[=TAG]            One or many tags that have assets you want to publish (multiple values allowed)

Customize error pages: Files created at `resources/views/errors/`.
> php artisan vendor:publish --tag=laravel-errors

Create `config/tinker.php`
> php artisan vendor:publish --provider="Laravel\Tinker\TinkerServiceProvider"

## view
> view:cache `Compile all of the application's Blade templates`

> view:clear `Clear all compiled view files`

