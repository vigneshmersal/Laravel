# Datatable

## install & setup
> composer require yajra/laravel-datatables-oracle

config/app.php
```php
'providers' => [
 Yajra\Datatables\DatatablesServiceProvider::class,
]
'aliases' => [
 'Datatables' => Yajra\Datatables\Facades\Datatables::class,
]
```

> php artisan vendor:publish

## controller
```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AjaxCrud;
use Validator;

class AjaxCrudController extends Controller
{
    public function index()
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
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $rules = array(
            'first_name'    =>  'required',
            'last_name'     =>  'required',
            'image'         =>  'required|image|max:2048'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $image = $request->file('image');
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $new_name);

        AjaxCrud::create($request->all());

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = AjaxCrud::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }

    public function update(Request $request)
    {
        $image_name = $request->hidden_image;
        $image = $request->file('image');

        $rules = array(
            'first_name'    =>  'required',
            'last_name'     =>  'required',
            'image'         =>  'image|max:2048'
        );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        if ($image != '') {
	        $image_name = rand() . '.' . $image->getClientOriginalExtension();
	        $image->move(public_path('images'), $image_name);
        }

        AjaxCrud::whereId($request->hidden_id)->update();

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $data = AjaxCrud::findOrFail($id);
        $data->delete();
    }
}

```
