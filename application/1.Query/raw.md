
## Select
```php
$messages = Message::select(DB::raw('t.*'))->from(DB::raw('(SELECT * FROM messages ORDER BY created_at DESC) t'))->groupBy('t.from')->get();

->whereExists(function($query) {
    $query->select(DB::raw(1))->from('table1')->whereRaw("id = '100'");
})

groupPurchases() {
    return $this->hasMany('App\Purchase')->selectRaw('product_id, max(id) as aggregate')->groupBy(['product_id', 'product_type']);
}

# get
DB::table('table_name')->get()->value('email');
DB::select('select * from users where id = :id', ['id' => 1]);

// select all column
->select( DB::raw('SELECT * FROM `users`') );

// select with condition
->select('select * from users where id = ?', [1]);
// when else
->selectRaw("(CASE WHEN (gender = 1) THEN 'M' ELSE 'F' END) as gender_text")

// change table column name
->select('name', 'email as user_email')

// convert column value
->selectRaw('count(*) as user_count')
->selectRaw('YEAR(birth_date) as year')
->selectRaw('price - discount_price AS discount')
```

## Insert
```php
DB::insert('insert into users (id, name) values (?, ?)', [1, 'Dayle']);
// single
DB::table('users')->insert(['email'=>$email,'role'=>$role]);
// multiple
DB::table('users')->insert(['email'=>$email,'role'=>$role]);
```

## update
```php
DB::statement('UPDATE users SET role_id = 1 WHERE role_id IS NULL AND YEAR(created_at) > 2020');
DB::statement('ALTER TABLE projects AUTO_INCREMENT=123');
DB::update('update users set votes = 100 where name = ?', ['John']);
```

## delete
```php
DB::statement('DROP TABLE users');
DB::delete('delete from users where id=2');
```

## condition
```php
->whereRaw('price > IF(state = "TX", ?, 100)', [200])

```

## orderBy
```php
->havingRaw('COUNT(*) > 1')
->orderByRaw('(updated_at - created_at) desc')
```
