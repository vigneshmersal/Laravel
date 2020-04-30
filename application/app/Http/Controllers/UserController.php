<?php

use App\Http\Controllers\Filters\UserFilters;
use Illuminate\Http\Request;

// php artisan make:controller PhotoController --resource --model=Photo
class UserController extends AnotherClass
{
    public function __construct()
    {
        $this->middleware('log')->only('index');
        $this->middleware('subscribed')->except('store');

        $this->middleware(function ($request, $next) {
            // ...
            return $next($request);
        });

        # authorize resource controller
        $this->authorizeResource(Post::class, 'post');
    }

    public function index(Request $request)
    {
        $user = (new User)->newQuery();

        return $user;
    }

    public function index1(UserFilters $filters)
    {
        return User::filter($filters)->get();
    }

    function create()
    {
        $this->authorize('create', Post::class);
    }

    public function store(Request $request)
    {
        // validate
        $rules = array(
            'name'       => 'required',
            'email'      => 'required|email',
            'level' => 'required|numeric'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->except('password'));
        } else {
            // store

            Session::flash('message', 'Successfully created records!');
        }
    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update($id)
    {
        $this->authorize('update', $post);
    }

    public function update1(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        Session::flash('message', 'Successfully deleted the records!');
    }

    /**
     * Single Action Controllers
     * php artisan make:controller ShowProfile --invokable
     * @param  int  $id
     * @return View
     */
    public function __invoke($id)
    {

    }
}
