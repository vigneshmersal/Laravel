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
    }

    public function store(Request $request)
    {
        $rules = array(
            'first_name'    =>  'required',
            'last_name'     =>  'required',
            'image'         =>  'required|image|max:2048'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $image = $request->file('image');

        $new_name = rand() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('images'), $new_name);

        AjaxCrud::create($form_data);

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
     * @param  int  $id
     * @return View
     */
    public function __invoke($id)
    {

    }
}
