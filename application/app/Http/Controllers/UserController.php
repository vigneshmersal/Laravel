<?php

use App\Http\Controllers\Filters\UserFilters;
use Illuminate\Http\Request;

// php artisan make:controller PhotoController --resource --model=Photo
class UserController extends AnotherClass
{
    public function __construct()
    {
        $this->middleware('log')->only('index');
        $this->middleware('guest')->except('logout'); // except method name

        $this->middleware(function ($request, $next) {
            // ...
            return $next($request);
        });

        # authorize resource controller
        $this->authorizeResource(Post::class, 'post');

        # App\Http\Controllers\FooBarController@getuser
        $currentAction = \Route::currentRouteAction();
        list($controller, $method) = explode('@', $currentAction);
        // $controller now is "App\Http\Controllers\FooBarController"
        // $method now is "getuser"
        $controller = preg_replace('/.*\\\/', '', $controller);
        // $controller now is "FooBarController"
    }

    public function index(Request $request)
    {
        $user = $user->newQuery();
        if ($request->has('city')) {
            $user->where('city', $request->input('city'));
        }
        return $user->get();

        if(request()->ajax())
        {
            return datatables()->of(AjaxCrud::latest()->get())
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('ajax_index');
        // (or)
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
        abort_if(Gate::denies('question_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        abort_unless($request->filled(['mock_test_id']), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    public function store(Request $request)
    {
        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = AjaxCrud::findOrFail($id);
            return response()->json(['data' => $data]);
        }
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
     * Route::get('user/{id}', 'UserController');
     */
    public function __invoke($id)
    {

    }
}
