<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    */

    // Auth::loginUsingId(1);

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     * @var string
     */
    protected function redirectTo()
    {
        return '/login';
    }

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username() {
        return 'email';
    }

    protected function credentials(Request $request) {
        return array_merge($request->only($this->username(), 'password'), ['status' => 1]);
    }

    public function authenticated(Request $request, $user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.index');
        }

        if ($request->has('redirect_to') && $request->redirect_to) {
            if ($request->redirect_to == "response") {
                return response()->json([ 'message' => 'success', 'user_id' => $user->id ]);
            }
            return redirect()->route($request->redirect_to);
        }

        if ($request->session()->has('url.intended')) {
            return redirect()->intended();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }

    public function Apilogout(Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($user) {
            $user->api_token = null;
            $user->save();
        }

        return response()->json(['data' => 'User logged out.'], 200);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            $user->generateToken();

            return response()->json([
                'data' => $user->toArray(),
            ]);
        }

        return $this->sendFailedLoginResponse($request);
    }
}
