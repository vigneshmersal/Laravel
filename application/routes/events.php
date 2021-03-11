<?php
use Illuminate\Support\Facades\Event;
use function Illuminate\Events\queueable;

// EventServiceProvider -> boot() -> add require base_path('routes/events.php');
Event::listen(GiftPurchased::class, function (GiftPurchased $event) { dd($event); });
// or
Event::listen(function (GiftPurchased $event) { dd($event); });
// or queue
Event::listen(queueable(function (GiftPurchased $event) { dd($event); }));
