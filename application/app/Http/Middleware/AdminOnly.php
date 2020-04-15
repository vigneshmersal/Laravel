<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminOnly {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        // before request is handled by the application

        if (! $request->user()->hasRole($role)) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->age <= 50) {
            return redirect()->route('HomePage');
        }

        $response = $next($request);

        // after request is handled by the application

        return $response;
    }

    /**
     * some work after the HTTP response has been sent to the browser.
     * @param  [type] $request  [description]
     * @param  [type] $response [description]
     */
    public function terminate($request, $response)
    {
        // Store the session data...
    }

}
