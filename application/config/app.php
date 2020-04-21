<?php

return [
    // Ajax prefix url
    'ajax_app_url' => Illuminate\Support\Str::finish( env('APP_URL', 'http://localhost') , "/" ),

    // Api key for access
    'api_key' => env('API_KEY', '12345'),

    'providers' => [
        /*
         * Package Service Providers...
         */
        Xethron\MigrationsGenerator\MigrationsGeneratorServiceProvider::class,
        MaddHatter\LaravelFullcalendar\ServiceProvider::class,

        /*
         * Custom Application Service Providers...
         */
        App\Providers\ResponseMacroServiceProvider::class,
        App\Providers\ViewServiceProvider::class,
    ],

    'aliases' => [
        /*
         * Custom Alias
         */
        'Stripe' => Cartalyst\Stripe\Laravel\Facades\Stripe::class,
        'Calendar' => MaddHatter\LaravelFullcalendar\Facades\Calendar::class,
    ],
];
