<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        # waiting until the view is about to render
        View::composer( 'profile', 'App\Http\View\Composers\ProfileComposer' );
        View::composer( ['profile', 'dashboard'], 'App\Http\View\Composers\ProfileComposer' );
        View::composer('*', 'App\Http\View\Composers\ProfileComposer');

        # executed immediately after the view is instantiated
        View::creator('profile', 'App\Http\View\Creators\ProfileCreator');

        # Using Closure based composers...
        View::composer('dashboard', function ($view) { });
    }
}
