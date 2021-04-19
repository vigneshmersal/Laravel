# Queue
https://divinglaravel.com/pushing-jobs-to-queue
https://divinglaravel.com/preparing-jobs-for-queue

## Install
> php artisan queue:table
> php artisan queue:failed-table
> php artisan migrate
> QUEUE_CONNECTION:database - .env

## Queue
// need to restart everytime make changes
> php artisan queue:work redis --queue=high,default --tries=3 --timeout=60 --sleep=3 --delay=3

// doesn't need to restart, when make some changes
> php artisan queue:listen --queue=high,default
> dispatch((new Job)->onQueue('high'));
> php artisan queue:restart

// view failed jobs
> php artisan queue:failed

// rerun failed job
> php artisan queue:retry 5
> php artisan queue:retry all
> php artisan queue:retry --range 200-510

// delete failed job
> php artisan queue:forget 5
> php artisan queue:flush

## Mail
```php
Mail::to($request->user())->queue(new OrderShipped($order));

Mail::to($request->user())->later($when, new OrderShipped($order));
```

## dispatch
```php
Queue::push(new InvoiceEmail($order));
Bus::dispatch(new InvoiceEmail($order));
(new InvoiceEmail($order))->dispatch();

dispatch(new InvoiceEmail($order))
    ->onConnection('default')
    ->onQueue('emails')
    ->delay(60);

ProcessPodcast::dispatch($podcast)->delay(now()->addMinutes(10));
SendNotification::dispatchAfterResponse();
ProcessPodcast::dispatchNow($podcast);

ProcessPodcast::dispatchIf($accountActive === true, $podcast);
ProcessPodcast::dispatchUnless($accountSuspended === false, $podcast);

dispatch(function () { Mail::to($to)->send(new Welcome); })->afterResponse();
```

## AppServiceProvider
```php
Queue::failing(function (JobFailed $event) {
    // $event->connectionName, $event->job, $event->exception
    Queue::before(function (JobProcessing $event) {
        // $event->connectionName, $event->job, $event->job->payload()
    });
    Queue::after(function (JobProcessed $event) {
        // $event->connectionName, $event->job, $event->job->payload()
    });
});
```

## Release

https://digitaloceancode.com/deploy-laravel-on-digital-ocean-queue-worker-supervisor-7/
https://ekn.me/2019-11-05/how-to-use-laravel-queue-worker-with-supervisor
https://saywebsolutions.com/blog/installing-supervisor-manage-laravel-queue-processes-ubuntu#toc-0

bitfumes/deploy.git
> sudo apt-get install supervisor
// test install
> service supervisor status
> cd /etc/supervisor/conf.d
# create a new file via vim
> sudo vim /etc/supervisor/conf.d/laravel-worker.conf
# Now setting up command here

```php
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/project/htdocs/artisan queue:work
autostart=true
autorestart=true
user=root
numprocs=8
redirect_stderr=true
stdout_logfile=/var/www/analysis.guidely.in/htdocs/storage/logs/worker.log
stopwaitsecs=3600

// or
command=sudo php /var/www/laravel/artisan queue:work --tries=3 --daemon
```
> sudo supervisorctl reread
	queue-worker: available
> sudo supervisorctl update
	queue-worker: added process group
// check running
> supervisorctl status
	laravel-worker:queue_00                   RUNNING   pid 2093, uptime 0:01:46
> sudo supervisorctl reload
> sudo service supervisor restart
> php artisan queue:restart
> sudo supervisorctl start laravel-worker:*
// or
> sudo supervisorctl start all

## modify
> sudo supervisorctl reread
> sudo supervisorctl update
> supervisorctl
    - stop all
    - start all
> sudo supervisorctl start laravel-worker:*
> php artisan queue:restart

## Redis
```php
Redis::throttle('fetch-metrics')->allow(60)->every(100)->block(120)
    ->then(function () use ($job) {
    // Fetch Google API
}, function () {
    return $this->release(20);
});
```
