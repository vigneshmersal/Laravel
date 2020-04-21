<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;

class SetDefaultLocaleForUrls
{
    public function handle($request, Closure $next)
    {
    	// Route::get('/{locale}/posts', '')->middleware('locale');
        URL::defaults(['locale' => $request->user()->locale]);

        return $next($request);
    }
}
