# Column

### Datatable with Model
In this example, we will create a DataTable service class.
**Usage:**
```
php artisan datatables:make User --model
```
This will create an `PostsDataTable` class on `app\DataTables` directory.
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
			->addColumns(['foo','bar','buzz'=>"red"]) // Add hidden model columns

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

        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
			->columns($this->getColumns())
			->ajax('')
			->addAction(['width' => '80px'])
			->parameters($this->getBuilderParameters());
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

## Creating a DataTable Scope service class

DataTable scope is class that we can use to limit our database search results based on the defined query scopes.

```
php artisan datatables:scope ActiveUser
```

This will create an `ActiveUser` class on `app\DataTables\Scopes` directory.

```php
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

Route::get('user-data', function() {
	$model = App\User::query();
	return DataTables::eloquent($model)->toJson();
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
		"updated_at": "2016-07-31 23:26:14",
		"deleted_at": null,
		"superior_id": 0,
		"foo":"value",
		"bar":"value",
		"buzz":"red"
	}]
}
```
