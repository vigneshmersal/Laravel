<?php
use App\User;

class AuthController extends AnotherClass
{

	public function register(Request $request)
	{
		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => bcrypt($request->password),
		]);

		$token = auth()->login($user);

		return $this->respondWithToken($token);
	}

	public function login(Request $request)
	{
		$validation = Validator::make($request->all(),[
    		'email' => 'required',
    		'password' => 'required',
    	]);

    	if($validation->fails()){
    		$data = api_validation_error('Validation Errors',$validation->messages());
    		return response()->json($data,422);
    	}

    	if(Auth::attempt($request->only('email','password'))){
    		$user = $request->user();

    		Token::where('user_id',$user->id)->update(['revoked'=>1]);
    		$tokenObj = $user->createToken('user access token');
    		$token = $tokenObj->token;
			$token->expires_at = Carbon::now()->addWeeks(2);
        	$token->save();

        	$token->accessToken;
        	$token = $tokenObj->accessToken;

    		return response()->json($data);
			return $this->respondWithToken($token);
    	}else{
			return response()->json(['error' => 'Unauthorized'], 401);
    	}

	}

	protected function respondWithToken($token)
	{
		return response()->json([
			'access_token' => $token,
			'token_type' => 'bearer',
			'expires_in' => auth()->factory()->getTTL() * 60
		]);
	}
}
