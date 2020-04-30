<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     * These middleware are run during every request to your application.
     * @var array
     */
    protected $middleware = [
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            # when update password - handle sessions on other devices
            \Illuminate\Session\Middleware\AuthenticateSession::class,
        ],

        'api' => [
            'throttle:60,1',
            'auth:api',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [

        // register custom middleware
        'adminOnly' => \App\Http\Middleware\AdminOnly::class,
        'prevent-back-history' => \App\Http\Middleware\PreventBackHistory::class,
        'locale' => \App\Http\Middleware\SetDefaultLocaleForUrls::class,
    ];

    /**
     * The priority-sorted list of middleware.
     * This forces non-global middleware to always be in the given order.
     * @var array
     */
    protected $middlewarePriority = [

    ];
}
