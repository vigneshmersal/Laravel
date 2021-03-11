https://laravel.com/api/7.x/Illuminate/Queue/Jobs/Job.html#method_uuid

```php
$job_id = $this->job->getJobId();
$uuid = $this->job->uuid();
```

```php
$batch = Bus::batch([
    new ProcessPodcast(Podcast::find(1)),
    new ProcessPodcast(Podcast::find(2)),
])->then(function (Batch $batch) {
    // All jobs completed successfully...
})->catch(function (Batch $batch, Throwable $e) {
    // First batch job failure detected...
})->finally(function (Batch $batch) {
    // The batch has finished executing...
})->name('Process Podcasts')
  ->allowFailures(false)
  ->onConnection('redis')
  ->onQueue('podcasts')
  ->dispatch();

// or

Bus::batch([
    [ new ReleasePodcast(1), new SendPodcastReleaseNotification(1), ],
    [ new ReleasePodcast(2), new SendPodcastReleaseNotification(2), ],
])

if ($this->batch()->cancelled()) {}
return Bus::findBatch($batchId);
```
