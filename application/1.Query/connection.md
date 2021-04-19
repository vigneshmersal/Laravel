
# Migration
```php
Schema::connection($connection)->create(function(Blueprint $table) {}
```

# Model
```php
protected $connection = 'mysql2';
```

# controller
```php
$user = User::on('mysql2')->find(1);
$db = DB::connection('mysql2');
```