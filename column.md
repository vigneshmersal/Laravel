# [Datatable](https://yajrabox.com/docs/laravel-datatables/master/installation)
## Installation
### Buttons Plugin Installation
```
composer require yajra/laravel-datatables-buttons:^4.0
php artisan vendor:publish --tag=datatables-buttons
```

## CSS links
```
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
```

## JS links
```
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
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
use Yajra\DataTables\Services\DataTable;

class PostsDataTable extends DataTable
{

    /**
     * Build DataTable class.
     *
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable()
    {
        return $this->datatables->eloquent($this->query())
            ->addColumn('intro', 'Hi {{$name}}!', 2) // Add Column with Blade Syntax && Add Column with specific order(2)
            ->addColumn('intro', function(User $user) { return 'Hi ' . $user->name . '!'; }) // Add Column with Closure
            ->addColumn('intro', 'users.datatables.intro') // Add Column with View - Hi {{ $name }}!
            ->addColumns(['buzz'=>"red"]) // Add hidden model columns

            ->blacklist(['password']) // Black listing columns - Sorting and searching will not work
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Post::query();
        $query = $query->where('id', $this->id); // id get from -> Sending parameter to DataTable class (->with(['key', 'value'])) at router
        return $this->applyScopes($query);
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
            ->columns($this->getColumns())
            ->ajax('')
            ->addAction(['width' => '80px'])
            ->parameters($this->getBuilderParameters());
            ->parameters([
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
            'id',
            // add your columns
            'created_at',
            'updated_at',
        ];
    }

    /**
     * Get filename for export. Export filename:
     *
     * @return string
     */
    protected function filename()
    {
        return 'posts_' . time();
    }
}
```

## Example Route:
```php
use App\DataTables\UsersDataTable;

Route::get('users', function(UsersDataTable $dataTable) {
    return $dataTable->render('users.index');
});
```

## Example View:
```php
@extends('app')

@section('content')
    {!! $dataTable->table() !!}
@endsection

@push('scripts')
https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    {!! $dataTable->scripts() !!}
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

Route::get('user-data', function(RolesDataTable $dataTable) {
    $model = App\User::query();
    return DataTables::of($model)
        ->with(['key' => 'value']) // Sending parameter to DataTable class
        ->make();

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
        ajax: '{{ url('index') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' }
        ],
        columnDefs: [{ // add design
            targets: [0, 1, 2],
            className: 'mdl-data-table__cell--non-numeric'
        }]
    });
});
```

## Example Response
```json
{
    "draw": 2,
    "recordsTotal": 10,
    "recordsFiltered": 3,
    "data": [{
        "id": 476,
        "name": "Esmeralda Kulas",
        "email": "abbott.cali@heaney.info",
        "created_at": "2016-07-31 23:26:14",
        "buzz":"red"
    }],
    "queries": [
        {
            "query": "select count(*) as aggregate from (select '1' as `row_count` from `users` where `users`.`deleted_at` is null and `users`.`deleted_at` is null) count_row_table",
            "bindings": [],
            "time": 1.84
        }, {
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
            }, {
                "data": "name",
                "name": "",
                "searchable": "true",
                "orderable": "true",
                "search": {
                    "value": "",
                    "regex": "false"
                }
            }, {
                "data": "email",
                "name": "",
                "searchable": "true",
                "orderable": "true",
                "search": {
                    "value": "",
                    "regex": "false"
                }
            }, {
                "data": "created_at",
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
