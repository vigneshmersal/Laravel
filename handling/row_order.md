# Table records reordering
[source1](https://github.com/LaravelDaily/Laravel-Restaurant-Menu)
[source2](https://github.com/LaravelDaily/Laravel-Datatables-Reordering)

migration
```php
$table->integer('position')->nullable();
```

validation
```php
'position'    => ['nullable','integer']
```

route
```php
Route::post('meals/reorder', 'MealsController@reorder')->name('meals.reorder');
```

model
```php
public function meals()
{
    return $this->hasMany(Meal::class)->orderBy('position', 'asc');
}

public function saveQuietly()
{
	// when update it won't call observers
    return static::withoutEvents(function() {
        return $this->save();
    });
}
```

AppServiceProvider.php
```php
Meal::observe(MealObserver::class);
```

MealObserver
```php
<?php

namespace App\Observers;

use App\Meal;

class MealObserver
{
    /**
     * Handle the meal "creating" event.
     *
     * @param  \App\Meal  $meal
     * @return void
     */
    public function creating(Meal $meal)
    {
        if (is_null($meal->position)) {
            $meal->position = Meal::where('category_id', $meal->category_id)->max('position') + 1;
            return;
        }

        $lowerPriorityMeals = Meal::where('category_id', $meal->category_id)
            ->where('position', '>=', $meal->position)
            ->get();

        foreach ($lowerPriorityMeals as $lowerPriorityMeal) {
            $lowerPriorityMeal->position++;
            $lowerPriorityMeal->saveQuietly();
        }
    }

    /**
     * Handle the meal "updating" event.
     *
     * @param  \App\Meal  $meal
     * @return void
     */
    public function updating(Meal $meal)
    {
        if ($meal->isClean('position')) {
            return;
        }

        if (is_null($meal->position)) {
            $meal->position = Meal::where('category_id', $meal->category_id)->max('position');
        }

        if ($meal->getOriginal('position') > $meal->position) {
            $positionRange = [
                $meal->position, $meal->getOriginal('position')
            ];
        } else {
            $positionRange = [
                $meal->getOriginal('position'), $meal->position
            ];
        }

        $lowerPriorityMeals = Meal::where('category_id', $meal->category_id)
            ->whereBetween('position', $positionRange)
            ->where('id', '!=', $meal->id)
            ->get();

        foreach ($lowerPriorityMeals as $lowerPriorityMeal) {
            if ($meal->getOriginal('position') < $meal->position) {
                $lowerPriorityMeal->position--;
            } else {
                $lowerPriorityMeal->position++;
            }
            $lowerPriorityMeal->saveQuietly();
        }
    }

    /**
     * Handle the meal "deleted" event.
     *
     * @param  \App\Meal  $meal
     * @return void
     */
    public function deleted(Meal $meal)
    {
        $lowerPriorityMeals = Meal::where('category_id', $meal->category_id)
            ->where('position', '>', $meal->position)
            ->get();

        foreach ($lowerPriorityMeals as $lowerPriorityMeal) {
            $lowerPriorityMeal->position--;
            $lowerPriorityMeal->saveQuietly();
        }
    }
}
```

MealsController.php
```php
public function reorder(Request $request)
{
    foreach($request->input('rows', []) as $row)
    {
        Currency::find($row['id'])->update([
            'position' => $row['position']
        ]);
    }
    return response()->noContent();
}
```

index.blade.php
```php
<script>
$(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.countries.index') }}",
    columns: [
        { data: 'placeholder', name: 'placeholder' },
        { data: 'id', name: 'id' },
        { data: 'position', name: 'position', visible: false, searchable: false },
        { data: 'name', name: 'name' },
        { data: 'short_code', name: 'short_code' },
        { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    order: [[ 2, 'asc' ]],
    pageLength: 100,
    rowReorder: {
        selector: 'tr td:not(:first-of-type,:last-of-type)',
        dataSrc: 'position'
    },
  };

  let datatable = $('.datatable-Country').DataTable(dtOverrideGlobals);
    datatable.on('row-reorder', function (e, details) {
        if(details.length) {
            let rows = [];
            details.forEach(element => {
                rows.push({
                    id: datatable.row(element.node).data().id,
                    position: element.newData
                });
            });

            $.ajax({
                headers: {'x-csrf-token': _token},
                method: 'POST',
                url: "{{ route('admin.countries.reorder') }}",
                data: { rows }
            }).done(function () { datatable.ajax.reload() });
        }
    });
});

</script>
```
