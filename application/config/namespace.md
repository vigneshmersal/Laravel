# Laravel Namespace
```php
// modal
use App\ { User };

use Illuminate\Http\Request;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Validation\Rule;

// pagination
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

// Database
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;

# Role & Permission
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// Exception
use Exception;
InvalidArgumentException;
use Illuminate\Auth\AuthenticationException,
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\HttpException,
use Illuminate\Database\Eloquent\ModelNotFoundException,
use Illuminate\Validation\ValidationException,
use Illuminate\Session\TokenMismatchException;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Cache\LockTimeoutException;
```

## config/app.php
```php
'App'          => Illuminate\Support\Facades\App::class,
'Arr'          => Illuminate\Support\Arr::class,
'Artisan'      => Illuminate\Support\Facades\Artisan::class,
'Auth'         => Illuminate\Support\Facades\Auth::class,
'Blade'        => Illuminate\Support\Facades\Blade::class,
'Broadcast'    => Illuminate\Support\Facades\Broadcast::class,
'Bus'          => Illuminate\Support\Facades\Bus::class,
'Cache'        => Illuminate\Support\Facades\Cache::class,
'Config'       => Illuminate\Support\Facades\Config::class,
'Cookie'       => Illuminate\Support\Facades\Cookie::class,
'Crypt'        => Illuminate\Support\Facades\Crypt::class,
'DB'           => Illuminate\Support\Facades\DB::class,
'Eloquent'     => Illuminate\Database\Eloquent\Model::class,
'Event'        => Illuminate\Support\Facades\Event::class,
'File'         => Illuminate\Support\Facades\File::class,
'Gate'         => Illuminate\Support\Facades\Gate::class,
'Hash'         => Illuminate\Support\Facades\Hash::class,
'Lang'         => Illuminate\Support\Facades\Lang::class,
'Log'          => Illuminate\Support\Facades\Log::class,
'Mail'         => Illuminate\Support\Facades\Mail::class,
'Notification' => Illuminate\Support\Facades\Notification::class,
'Password'     => Illuminate\Support\Facades\Password::class,
'Queue'        => Illuminate\Support\Facades\Queue::class,
'Redirect'     => Illuminate\Support\Facades\Redirect::class,
'Redis'        => Illuminate\Support\Facades\Redis::class,
'Request'      => Illuminate\Support\Facades\Request::class,
'Response'     => Illuminate\Support\Facades\Response::class,
'Route'        => Illuminate\Support\Facades\Route::class,
'Schema'       => Illuminate\Support\Facades\Schema::class,
'Session'      => Illuminate\Support\Facades\Session::class,
'Storage'      => Illuminate\Support\Facades\Storage::class,
'Str'          => Illuminate\Support\Str::class,
'URL'          => Illuminate\Support\Facades\URL::class,
'Validator'    => Illuminate\Support\Facades\Validator::class,
'View'         => Illuminate\Support\Facades\View::class,
'Stripe'       => Cartalyst\Stripe\Laravel\Facades\Stripe::class,
'Calendar'     => MaddHatter\LaravelFullcalendar\Facades\Calendar::class,
```
