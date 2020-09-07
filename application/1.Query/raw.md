## get
```php
# get
DB::table('table_name')->get()->value('email');

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

## update
```php
DB::statement('UPDATE users SET role_id = 1 WHERE role_id IS NULL AND YEAR(created_at) > 2020');
DB::statement('ALTER TABLE projects AUTO_INCREMENT=123');
```

## delete
```php
DB::statement('DROP TABLE users');
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
