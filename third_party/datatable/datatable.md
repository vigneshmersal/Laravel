# [Datatable](https://yajrabox.com/docs/laravel-datatables/master/installation)
## Installation
[https://github.com/yajra/laravel-datatables](https://github.com/yajra/laravel-datatables)
### Buttons Plugin Installation
```
composer require yajra/laravel-datatables
composer require yajra/laravel-datatables-buttons:^4.0
php artisan vendor:publish --tag=datatables-buttons
```

## CSS links
```
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<link  href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
```

## JS links
```
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
```

## Modal
### Datatable with Model
In this example, we will create a DataTable service class.
```
php artisan datatables:make User --model
```
**Usage:** This will create an `PostsDataTable` class on `app\DataTables` directory.

```php
<?php
namespace App\DataTables;

use App\Post;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PostsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()->eloquent($query)
            ->addColumn('intro', 'Hi {{$name}}!', 2) // Add Column with Blade Syntax && Add Column with specific order(2)
            ->addColumn('intro', function(User $user) {
                return $user->posts->map(function($post) { // Eager loading Relationships
                        return str_limit($post->title, 30, '...');
                })->implode('<br>');
            })
            ->addColumn('actions', function(User $user) {
                return "<a class='btn btn-sm bg-info-light' href='".route("user.show", $user)."'>
                            <i class='fe fe-eye'></i> View
                        </a>";
            })
            ->addColumn('action', 'users.action') // Add Column with View - Hi {{ $name }}!
            ->addColumns(['buzz'=>"red"]) // Add hidden model columns

            ->editColumn('name', 'Hi {{$name}}!')
            ->editColumn('created_at', function(User $user) {
                return Carbon::parse($user->created_at)->format('d-m-Y h:i A');
            })

            ->only(['id','name']) // Get only selected columns

            ->removeColumn('password')

            ->escapeColumns() // Escape all columns for XSS methods
            ->escapeColumns([]) // Remove escaping of all columns
            ->escapeColumns([0]) // Escape by output index
            ->escapeColumns(['name']) // Escape selected fields

            ->rawColumns(['action'])

            ->addIndexColumn([
                'defaultContent' => '',
                'data'           => 'DT_RowIndex',
                'name'           => 'DT_RowIndex',
                'title'          => '',
                'render'         => null,
                'orderable'      => false,
                'searchable'     => false,
                'exportable'     => false,
                'printable'      => true,
                'footer'         => '',
            ])

            ->with(['posts' => 100]) // add additional server data on your response { "posts": 100 }
            ->with('comments', function() use ($model) { return $model->count(); })
            ->withQuery('count', function($filteredQuery) { return $filteredQuery->count(); })

            ->setRowId('id') // Set the RowID
            ->setRowId(function ($user) { return $user->id; })
            ->setRowId('{{$id}}')
            ->setRowClass(function ($user) { return $user->id % 2 == 0 ? 'success' : 'warning'; })
            ->setRowClass('{{ $id % 2 == 0 ? "success" : "warning" }}')
            ->setRowData([
                'data-id' => function($user) { return 'row-' . $user->id; },
                'data-name' => 'row-{{$name}}',
            ])
            ->setRowAttr([
                'color' => function($user) { return $user->color; },
                'color' => '{{$color}}'
            ])

            ->whitelist(['name', 'email']) // Sorting and searching will only work on columns
            ->startsWithSearch() // starts with the given keyword
            ->smart(false) // '%$keyword%'

            ->filterColumn('fullname', function($query, $name) { // filter column for custom search
                $query->where('name', $name);
            })
            ->filter(function ($query) {
                if (request()->has('name')) {
                    $query->where('name', 'like', "%" . request('name') . "%");
                }
            }, true) // true - Manual Searching with Global Search

            ->makeHidden('posts')
            ->blacklist(['password']) // Black listing columns - Sorting and searching will not work

            ->order(function ($query) {
                if (request()->has('name')) {
                    $query->orderBy('name', 'asc');
                }
            })
            ->orderByNullsLast()
            ->orderColumn('name', '-name $1') // order nulls as last result
            ->orderColumns(['name', 'email'], '-:column $1') // order by multiple column
            ->orderColumn('name', function ($query, $order) {
                $query->orderBy('status', $order);
            })

            ->setTransformer(new App\Transformers\UserTransformer) // https://github.com/yajra/laravel-datatables-docs/blob/master/response-fractal.md
            ->setSerializer(new App\Serializers\CustomSerializer)

            ->skipTotalRecords() // improve dataTables response time & skipping the total records count query and settings its value equals to the filtered total records.
            ->setTotalRecords(100) // manually set the total records count
            ->setFilteredRecords(100) // manually set the filtered records count
            ->skipPaging()
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Post $post)
    {
        $query = Post::query();
        $query = $query->where('id', $this->id); // id get from -> Sending parameter to DataTable class (->with(['key', 'value'])) at router
        return $this->applyScopes($query);
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    protected $actions = ['print', 'excel', 'myCustomAction']; // disabling the csv and pdf action

    public function html()
    {
        return $this->builder()
            ->postAjax(['url'=>'', 'data'])
            ->ajax([ // tell where to fetch it's data.
                'url' => route('users.index'),
                'type' => 'GET',
                'headers' => ['X-CSRF-TOKEN' => csrf_token()],
                'data' => "function(data){ // pass custom data
                        d.key = 'value';
                        data.fromDate = $('input#fromDate').val();
                    }"
            ])
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax($url, $script = '', $data = []) // shortening the url
            ->scrollY(config('admin.scrollY'))
            ->dom('Bfrtip')
            ->orderBy(1) // 1 - asc , 2 - desc
            ->responsive()
            ->stateSave()
            ->buttons(
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
                Button::makeIfCan('permissions.manage', 'create')->editor('editor')->className('btn-success'),
                Button::makeIfCan('permissions.manage', 'edit')->editor('editor')->className('btn-warning'),
                Button::makeIfCan('permissions.manage', 'remove')->editor('editor')->className('btn-danger'),
                Button::make('colvis')
                      ->columns(':not(.noVis)')
                      ->text('<i class="fa fa-eye"></i>'),
                Button::make('csv')->text('<i class="fa fa-file-csv"></i>'),
            )
            ->addCheckbox([
                'defaultContent' => '<input type="checkbox" ' . $this->html->attributes($attributes) . '/>',
                'title'          => $this->form->checkbox('', '', false, ['id' => 'dataTablesCheckbox']), // <th>{{$title}}</th>
                'data'           => 'checkbox', // This is the key from the json response data array.
                'name'           => 'checkbox',
                'orderable'      => false,
                'searchable'     => false,
                'exportable'     => false,
                'printable'      => true,
                'width'          => '10px',
            ])
            ->addAction([ // edit option column
                'width'          => '80px',
                'defaultContent' => '',
                'data'           => 'action',
                'name'           => 'action',
                'title'          => 'Action',
                'render'         => null,
                'orderable'      => false,
                'searchable'     => false,
                'exportable'     => false,
                'printable'      => true,
                'footer'         => '', // <tfoot></tfoot> , To display the footer using html builder, pass true as 2nd argument on $builder->table([], true) api.
            ])
            ->parameters([ // js script
                'paging'       => true,
                'searching'    => true,
                'info'         => false,
                'searchDelay'  => 350,
                'pageLength' => 25,
                'processing' => true,
                'serverSide' => true,
                'responsive' => true,
                'language'     => [
                    'url' => url('js/dataTables/language.json')
                ]
                'dom'          => 'Bfrtip',
                'buttons'      => [
                    'export', // export - csv , excel , pdf
                    'print', // enable exporting to print
                    'excel', // enable exporting to excel
                    'csv', // enable exporting to csv
                    'pdf', // enable exporting to pdf
                    'reset', // enable reset button
                    'reload', // enable reload button
                    'myCustomAction'
                ],
                'drawCallback' => 'function() { alert("Table Draw Callback") }', // [more](https://github.com/yajra/laravel-datatables-docs/blob/master/html-builder-callbacks.md)
            ]);
    }

    public function myCustomAction()
    {
        //...your code here.
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')
                ->name('id')
                ->data('id')
                ->title('Id')
                ->searchable(true)
                ->orderable(true)
                ->render('function(){}')
                ->footer('Id')
                ->exportable(true)
                ->printable(true)
                ->width(60)->width('140px')
                ->addClass('text-center'),
            Column::make('name')
                ->render('$.fn.dataTable.render.boolean()')
                ->className('text-center')
                ->separator('General Information'),
            Column::computed('roles_count', 'Roles')
                ->render('$.fn.dataTable.render.badge("primary")')
            Column::checkbox('active'),
        ];
    }

    /**
     * Get filename for export. Export filename:
     *
     * @return string
     */
    protected function filename()
    {
        return 'posts_' . date('YmdHis');
    }
}
```

## Example Route:
```php
use App\DataTables\UsersDataTable;

Route::get('users', function(UsersDataTable $dataTable) {
    // single datatable
    return $dataTable->render('users.index');

    (or)

    return $dataTable->withHtml(function (Builder $builder) {
            $builder->ajax([
                'type' => 'POST',
                'headers' => ['X-CSRF-TOKEN' => csrf_token()],
                'url' => route('users.list'),
            ])->setTableAttribute('id', 'dt_users');
        })->render('users.list');

    // multiple datatable
    return Datatables::renderMultiple([
        'invitableDoctorsDataTable' => $invitableDoctorsDataTable,
        'doctorInvitationsDataTable' => $doctorInvitationsDataTable,
    ], 'users.index');

    // multiple datatable
    $active = ActiveUsersDataTableHtml::make();
    $inactive = InactiveUsersDataTableHtml::make();

    return view('users.index', compact('active', 'inactive'));

    // multiple datatable
    $inactive = InactiveUsersDataTableHtml::make();

    return $dataTable->render('users.index', compact('inactive'));
});
```

## Example View:
```php
@extends('app')

@section('content')
    {!! $dataTable->table([
        'class' => 'table table-bordered'
    ], true) !!}
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    {!! $dataTable->scripts() !!}

    reload() {
        window.LaravelDataTables["user-table"].ajax.reload();
    }
@endpush
```

## Creating a DataTable Scope service class
DataTable scope is class that we can use to limit our database search results based on the defined query scopes.
```
php artisan datatables:scope ActiveUser
```
This will create an `ActiveUser` class on `app\DataTables\Scopes` directory.

```php
<?php
namespace App\DataTables\Scopes;

use Yajra\DataTables\Contracts\DataTableScopeContract;

class ActiveUser implements DataTableScopeContract
{
    /**
     * Apply a query scope.
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public function apply($query)
    {
         return $query->where('active', true);
    }
}
```

## Using Directly at Router
```php
use DataTables;
use Yajra\DataTables\Html\Builder;

Route::get('user-data', function(RolesDataTable $dataTable) {
    $users = App\User::query();
    $resource = App\Http\Resources\UserResource::collection($users); // Using Resource Response
    return DataTables::of($users)->make();

    $request = $dataTable->getRequest();
    $html = $builder->columns([]);

    // or

    return $dataTable->before(function (\Yajra\DataTables\DataTableAbstract $dataTable) {
       return $dataTable->addColumn('test', 'added inside controller');
   })
   ->response(function (\Illuminate\Support\Collection $response) {
       $response['test'] = 'Append Data';
       return $response;
   })
   ->withHtml(function(\Yajra\DataTables\Html\Builder $builder) {
        $builder->columns(['id', 'name', 'etc...']);
   })
   ->with(['key', 'value'])
   ->render('path.to.view');
});
```

## Javascript Datatable
```js
$(function() {
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        order: [],
        dataType: "jsonp",
        ajax: {
            "type": "POST",
            "url": '/admin/bookings/datatables',
            "contentType": 'application/json; charset=utf-8',
            "data": { "_token": "" }
        },
        paging: false,
        columns: [
            {
                data: 'posts',
                data: function ( data ) {
                    if(!data.invoice_number){
                        return '<a data-id="'+ data._id +'">'+data.number+'</a>';
                    }
                },
                name: 'posts.title', // model relationship
                footer: 'Post',
                orderable: false,
                searchable: false,
            }
        ],
        columnDefs: [{ // add design
            targets: [0, 1, 2],
            targets: "_all",
            className: 'mdl-data-table__cell--non-numeric',
            defaultContent: "-",
        }],
        search: {
            "regex": true
        }
    });
});
```

## Example Response
```json
{
    "draw": 2,
    "recordsTotal": 10,
    "recordsFiltered": 3,
    "data": [
        {
            "id": 476,
            "name": "Esmeralda Kulas",
            "email": "abbott.cali@heaney.info",
            "created_at": "2016-07-31 23:26:14",
            "buzz":"red"
        }
    ],
    "queries": [
        {
            "query": "select * from `users` where `users`.`deleted_at` is null order by `name` asc limit 10 offset 0",
            "bindings": [],
            "time": 1.8
        }
    ],
    "input": {
        "draw": "1",
        "columns": [
            {
                "data": "id",
                "name": "",
                "searchable": "true",
                "orderable": "true",
                "search": {
                    "value": "",
                    "regex": "false"
                }
            }
        ],
        "order": [{
            "column": "1",
            "dir": "asc"
        }],
        "start": "0",
        "length": "10",
        "search": {
            "value": "",
            "regex": "false"
        },
        "_": "1479295888286"
}
```

## CONFIGURATIONS
The configuration file can be found at ``config/datatables.php``
### Error
- **NULL:** 'error' => null (or) throw
- **Response if Null** "error": "Exception Message:\n\nSQLSTATE[42S22]: Column not found: 1054 Unknown column 'xxx' in 'order clause' (SQL: select * from `users` where `users`.`deleted_at` is null order by `xxx` asc limit 10 offset 0)"

### Smart Search
The sql generated will be like ``column LIKE "%keyword%"`` when set to true.
```php
'smart' => true,
```

### Case Sensitive Search
Case insensitive will search the keyword in lower case format.
```php
'case_insensitive' => true,
```

### Index Column
```php
'index_column' => 'DT_RowIndex',
```

### Html Builder Config
Run
```
php artisan vendor:publish --tag=datatables-html
```
Published config is located at ``config/datatables-html.php``
```php
return [
    'table' => [
        'class' => 'table',
        'id' => 'dataTableId'
    ]
];
```
