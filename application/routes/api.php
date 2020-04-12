<?php
/*
|--------------------------------------------------------------------------
| GET | api/users | users.index | App\Http\Controllers\Api\UserController@index
| POST | api/users | users.store | App\Http\Controllers\Api\UserController@store
| GET | api/users/{post} | users.show | App\Http\Controllers\Api\UserController@show
| PUT | api/users/{post} | users.update | App\Http\Controllers\Api\UserController@update
| DELETE | api/users/{post} | users.destroy | App\Http\Controllers\Api\UserController@destroy
|--------------------------------------------------------------------------
*/

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');

// php artisan make:resource Users --collection
Route::apiResource('users','UserController');
