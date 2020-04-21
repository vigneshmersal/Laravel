<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register the application's response macros.
     *
     * @return void
     */
    public function boot()
    {
        # return response()->caps('foo');
        Response::macro('caps', function ($value) {
            return Response::make(strtoupper($value));
        });
    }
}
