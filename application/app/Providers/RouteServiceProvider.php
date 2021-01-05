<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    protected $adminNamespace = 'App\Http\Controllers\Admin';
    protected $doctorNamespace = 'App\Http\Controllers\Doctor';
    protected $patientNamespace = 'App\Http\Controllers\Patient';
    protected $apiNamespace = 'App\Http\Controllers\Api';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::pattern('id', '[0-9]+');
        Route::pattern('name', '[a-z]+');

        Route::model('user', App\User::class);
        Route::bind('doctor', function ($value) {
            return App\User::where(['name' => $value, 'role' => 'doctor'])->firstOrFail();
        });

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAdminWebRoutes();

        $this->mapDoctorWebRoutes();

        $this->mapPatientWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->name('api.')
            ->namespace($this->apiNamespace)
            ->group(base_path('routes/api.php'));
    }

    /**
    * Define the admin specific "web" routes for the application.
    * These routes all receive session state, CSRF protection, etc.
    *
    * @return void
    */
    protected function mapAdminWebRoutes()
    {
        Route::prefix('admin')
            ->name('admin.')
            ->middleware(['web', 'auth'])
            ->namespace($this->adminNamespace)
            ->group(base_path('routes/backEnd/admin.php'));
    }

    /**
    * Define the Doctor specific "web" routes for the application.
    * These routes all receive session state, CSRF protection, etc.
    *
    * @return void
    */
    protected function mapDoctorWebRoutes()
    {
        Route::prefix('doctor')
            ->name('doctor.')
            ->middleware(['web', 'auth'])
            ->namespace($this->doctorNamespace)
            ->group(base_path('routes/backEnd/doctor.php'));
    }

    /**
    * Define the Patient specific "web" routes for the application.
    * These routes all receive session state, CSRF protection, etc.
    *
    * @return void
    */
    protected function mapPatientWebRoutes()
    {
        Route::prefix('patient')
            ->name('patient.')
            ->middleware(['web', 'auth'])
            ->namespace($this->patientNamespace)
            ->group(base_path('routes/backEnd/patient.php'));
    }

    public function configureRateLimiting()
    {
        // ->middleware('throttle:api');
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(3);
            // or
            return $request->user()->id == 1
                ? Limit::none() // unlimited
                : Limit::perMinute(3);
        });
    }
}
