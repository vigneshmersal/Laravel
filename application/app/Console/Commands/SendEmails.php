<?php

namespace App\Console\Commands;

use App\DripEmailer;
use App\User;
use Illuminate\Console\Command;

# php artisan make:command SendEmails
class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send {user} {--queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send drip e-mails to a user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(DripEmailer $drip)
    {
        $this->info('hello command section there.');

        // call another artisan command
        $this->call('email:send', ['user' => 1]);
        $this->callSilent('email:send', ['user' => 1]); // suppress all of its output

        $drip->send(
            User::find(
                $this->argument('user')
            )
        );
    }
}
