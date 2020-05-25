<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);

        if ($this->app->environment() == 'local') {
        }

        try {
            # Sharing Data With All Views
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
        // Modify route verb names
        Route::resourceVerbs([
            'indx' => 'all',
            'create' => 'new',
            'store' => 'save',
            'edit' => 'modify',
            'update' => 'alter',
            'destroy' => 'delete',
        ]);

        # shorten path
        Blade::include('includes.input', 'input'); // @input(['type' => 'email'])

        # Extending blade  -> @datetime($var)
        Blade::directive('datetime', function ($expression) {
            return "<?php echo ($expression)->format('m/d/Y H:i'); ?>";
        });

        # Custom if statement -> @env('local') @elseenv('testing') @endenv
        Blade::if('env', function ($environment) {
            return app()->environment($environment);
        });

        Validator::extend('my_custom_validation_rule',
            function ($attribute, $value, $parameters, $validator) {
                return $value == 'foo';
            }, 'my custom validation rule message'
        );

        Validator::extend('my_custom_validation_rule', function ($attribute, $value, $parameters, $validator) {

            // Test custom message
            $customMessage = request()->get('field') ? "Foo doesn't exist" : "Foo exist";

            // Replace dynamic variable :custom_message with $customMessage
            $validator->addReplacer('my_custom_validation_rule',
                function($message, $attribute, $rule, $parameters) use ($customMessage) {
                    return \str_replace(':custom_message', $customMessage, $message);
                }
            );

            return false; // Test error message. (Make it always fail the validator)

        }, 'My custom validation rule message. :custom_message');

        # custom placeholder replacements for error messages
        Validator::replacer('foo', function ($message, $attribute, $rule, $parameters) {
            return str_replace();
        });

        Validator::extendImplicit('foo', function ($attribute, $value, $parameters, $validator) {
            return $value == 'foo';
        });

        # declare extending collection macros
        Collection::macro('toUpper', function () { // call : $upper = $collection->toUpper();
            return $this->map(function ($value) { return Str::upper($value); });
        });
    }
}
