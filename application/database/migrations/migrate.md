# migration

## Path to migrate
> php artisan migrate --path=/database/migrations/file.php

## Artisan commands
- migrate:reset = ROLLBACK ALL MIGRATIONS
- migrate:refresh = ROLLBACK AND MIGRATE
- migrate:fresh = DROP TABLES AND MIGRATE

## additional
nullable
default
unique
index
unsigned

## foreign relation
```php
$table->unsignedBigInteger('user_id')->index();
$table->foreign('user_id')->references('id')->on('users');

$table->integer('combo_type')->length(1)->default(0)->unsigned();
```

## Migrations with validation

```php
id
=> increments , tinyIncrements , smallIncrements , mediumIncrements , bigIncrements

name
=> char(191) , string(16,300) ,

description
=> text(65,535) , mediumText (16,777,215), longText(4,294,967,295)

amount - (numeric)
=> float(23) , decimal(30) , double(53)

votes
=> integer(4,294,967,295) , tinyInteger(255), mediumInteger(16,777,215) , bigInteger(18,446,744,073,709,551,615)

status
=> boolean

time => time , timeTz , timestamp , timestampTz
date => date , dateTime , dateTimeTz
year => year

ip - ipAddress
device - macAddress

json - json

created_at => timestamps , timestampsTz
deleted_at => softDeletes , softDeletesTz

=====CHECK=====
Schema::hasTable('users')
Schema::hasColumn('users', 'email')

=====DROP=====
$table->string('email')->nullable(false)->change();

$table->dropColumn('votes');

$table->dropUnique('users_email_unique');

$table->dropIndex(['state']);

Schema::enableForeignKeyConstraints();
$table->dropForeign(['user_id']);
Schema::disableForeignKeyConstraints();

Schema::drop('users'); // dropIfExists

=====Modifier=====
->first()
->after('column')
->autoIncrement()
->charset('utf8')
->collation('utf8_unicode_ci')
->comment('my comment')
->default($value)
->nullable($value = true)
->unsigned()
->useCurrent()

// rename column old
$table->integer('age')->change();
// rename column new
$table->rename('name', 'username');

=====CREATE & ALTER=====
Schema::create('shop_user_maps', function (Blueprint $table) {}
Schema::table('users', function (Blueprint $table) {}
ALTER TABLE customers ADD COLUMN id INT AUTO_INCREMENT PRIMARY KEY

$table->enum('color', ['red', 'blue']);

$table->increments('id');
$table->string('name');
$table->string('slug')->nullable();
$table->string('email')->unique()->index();
$table->string('mobile')->unique();
$table->string('designation');
$table->string('password');
$table->timestamp('email_verified_at')->nullable();
$table->rememberToken();
$table->boolean('active')->default(1);
$table->integer('created_by')->default(1);
$table->integer('updated_by')->nullable();
$table->integer('deleted_by')->nullable();
$table->timestamps();
$table->datetime('deleted_at')->nullable();
$table->softDeletes();
```
