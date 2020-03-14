# Column

You can add a custom column on your response by using `addColumn` api.

<a name="blade"></a>
## Column with Blade Syntax

```php
use DataTables;

Route::get('user-data', function() {
	$model = App\User::query();

	return DataTables::eloquent($model)
    ->addColumn('intro', 'Hi {{$name}}!', 2) // Add Column with Blade Syntax && Add Column with specific order(2)
    ->addColumn('intro', function(User $user) { return 'Hi ' . $user->name . '!'; }) // Add Column with Closure
    ->addColumn('intro', 'users.datatables.intro') // Add Column with View - Hi {{ $name }}!
    
    ->addColumns(['foo','bar','buzz'=>"red"]) // Add hidden model columns
    ->blacklist(['password']) // Black listing columns - Sorting and searching will not work

    ->toJson();
});
```
<a name="response"></a>
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
