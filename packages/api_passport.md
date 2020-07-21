# API passport
[laravel-json-api](https://laravel-json-api.readthedocs.io/en/latest/)

Install
> composer require laravel/passport

Create Passport tables
> php artisan migrate

Generate client encryption keys(token)
> php artisan passport:install

Add API trait to Models,
```php
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable {
    use HasApiTokens;
}
```

AuthServiceProvider.php
```php
use Laravel\Passport\Passport;
public function boot() {
    Passport::routes();
}
```

config/auth.php
```php
'api' => [
    'driver' => 'passport',
    'provider' => 'users',
    'hash' => false,
],
```

Login
```php
$response = $http->post('http://your-app.com/oauth/token', [
    'headers' => [
        'Accept' => 'application/json'
    ], [
    'form_params' => [
        'grant_type' => 'password',
        'client_id' => 'client-id', // from oauth_clients table (or) passport:install
        'client_secret' => 'client-secret', // from oauth_clients table (or) passport:install
        'username' => 'taylor@laravel.com', // email
        'password' => 'password',
        'scope' => '*',
    ],
]);
```

Get
```php
$response = $client->request('GET', '/api/user', [
    'headers' => [
        'Accept' => 'application/json',
        'Authorization' => 'Bearer '.$accessToken,
        'Content-Type' => 'application/x-www-form-urlencoded', // optional
    ],
]);
```

routes/web.php
```php
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', 'API\UserController@details');
});
```

API login/register
```php
<?php
namespace App\Http\Controllers\API;

use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 401;
    public $exceptionStatus = 500;

    public function login() {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:candidates,email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([ 'error' => 'Validation Error',
                    'error_details' => $validator->errors()
                ], $this->errorStatus);
            }

            if ( Auth::attempt( $request->only('email', 'password') ) ) {
                $token = auth()->user()->createToken('MyApp')-> accessToken;

                return response()->json([ 'token_type' => 'Bearer',
                    'access_token' => $token,
                ], $this->successStatus);
            } else {
                return response()->json([ 'error' => 'Unauthorised',
                    'error_details' => 'Invalid credentials'
                ], $this->errorStatus);
            }
        } catch (Exception | Throwable $exception) {
            return response()->json([ 'error' => 'Something went wrong',
                'error_details' => $exception->getMessage()
            ], $this->exceptionStatus);
        }
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'c_password' => 'required|same:password',
            ]);

            if ($validator->fails()) {
                return response()->json([ 'error' => 'Validation Error',
                    'error_details' => $validator->errors()
                ], $this->errorStatus);
            }

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);

            return response()->json([ 'name' => $user->name,
                'token' => $user->createToken('MyApp')-> accessToken,
            ], $this->successStatus);

        } catch (Exception | Throwable $exception) {
            return response()->json([ 'error' => 'Something went wrong',
                'error_details' => $exception->getMessage()
            ], $this->exceptionStatus);
        }
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json(['user' => $user], $this->successStatus);
    }
}
```
