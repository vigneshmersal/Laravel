<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\SendEmails::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function() { \Log::info("Task Schedular Called."); })->everyMinute();

        //deactivate expired offer
        $schedule->call(function(){
            TaskScheduleController::deactivate_expired_offer();
            // Offer::whereDate('expiry_date_time', '<=', Carbon::now() )->update(['is_active'=>0]);
        })->everyMinute();

        $schedule->command('email:send')->hourly();
        // ->weeklyOn(1, '13:00');
        // ->dailyAt('13:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
