<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);

        try {
            View::share('PageTitle', $PageTitle);
            View::share('PageDescription', $PageDescription);
            View::share('PageKeywords', $PageKeywords);
        } catch(\Exception $e) {
            \Log::info($e);
        }

        /**
         * Paginate a standard Laravel Collection.
         * $lists = $lists->collectionPaginate();
         * @param int $perPage
         * @param int $page
         * @param array $options
         * @return array
         */
        Collection::macro('collectionPaginate', function($perPage = null, $page = null, $options = [])
        {
            $perPage = $perPage ?? env('BACKEND_PAGINATION');
            $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
            $items = $this instanceof Collection ? $this : Collection::make($this);
            $paginate = new LengthAwarePaginator($this->forPage($page, $perPage), $this->count(), $perPage, $page, $options);
            return $paginate->setPath(Paginator::resolveCurrentPath());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
