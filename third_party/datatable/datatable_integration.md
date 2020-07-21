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
}

```
