## belongsToMany (many to many) {#belongsToMany}

```php
class User extends Model { // table - role_user
    public function roles() {
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id')
            ->using('App\RoleUser') // custom pivot table
            ->as('subscription') // rename 'pivot'
            ->withPivot('column1', 'column2') // pass additional data
            ->wherePivot('approved', 1)
            ->wherePivotIn('priority', [1, 2])
            ->wherePivotNotIn('priority', [1,2])
            ->withTimestamps();
    }
}

foreach ($user->roles as $role) { }
$roles = $user->roles()->orderBy('name')->get();

# Intermediate Table Columns Retrive
$role->pivot->created_at;

$users = User::with('podcasts')->get();
foreach ($users->flatMap->podcasts as $podcast) {  // flatMap instead of two foreach
    echo $podcast->subscription->created_at; // subscription instead of pivot
}

# attach given ids
$user->roles()->attach([$roleIds]);
$user->roles()->attach([$roleIds], ['expires' => $expires]); // with additional data
$user->roles()->attach([ 1 => ['expires' => $expires], 2 => ['expires' => $expires] ]); // with individual additional record

# detach given ids
$user->roles()->detach([$roleIds]); // Detach a single role from the user...
$user->roles()->detach(); // Detach all roles from the user...

// Any IDs that are not in the given array will be removed from the intermediate table
// only the IDs in the given array will exist in the intermediate table
$user->roles()->sync([1,2,3]);
$page->tags()->wherePivot('feature_id', 1)->sync($tagIds); // with condition
$user->roles()->sync([1 => ['expires' => true], 2, 3]); // pass additional data
$user->roles()->syncWithoutDetaching([1, 2, 3]); // If you do not want to detach existing IDs
$user->roles()->syncWithoutDetaching([ 1 => ['expires' => true] ]); // with additional data
$user->roles()->sync([1,2,3], false); // If you do not want to detach existing IDs

# sync ids array with additional data
foreach($data as $id){
    $syncData[$id] = ['question_score' => 1];
}
$paper->questions()->sync($syncData);

# If the given ID is currently attached, it will be detached. Likewise detached
$user->roles()->toggle([1, 2, 3]);
```
