# API passport
[laravel-json-api](https://laravel-json-api.readthedocs.io/en/latest/)

Install
- composer require laravel/passport
- php artisan migrate
- php artisan passport:install // Generate client encryption keys(token)

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

## get user without middleware
```php
return auth('api_candidates')->user();
```

```php
public function test(Request $request)
{
    $access_token = $request->header('Authorization');

    $auth_header = explode(' ', $access_token); // Bearer {token}
    $token = $auth_header[1]; // {token}

    // break up the token into its three parts
    $token_parts = explode('.', $token);

    $token_header_json = base64_decode($token_parts[1]); // base64 decode to get a json string
    // {"aud":"1","jti":"b9be7f5d0f8eb394e57dff0fb40a3ee17624d1a613e7f93704f2a3885d8bd2349372dd289f5e62d4","iat":1598771934,"nbf":1598771934,"exp":1630307934,"sub":"1","scopes":[]}

    // then convert the json to an array
    $token_header_array = json_decode($token_header_json, true);
    $user_token = $token_header_array['jti'];

    $user_id = DB::table('oauth_access_tokens')->where('id', $user_token)->value('user_id');
    return $user = User::findOrFail($user_id);
}
```
