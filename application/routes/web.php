<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

$route = Route::current();
$name = Route::currentRouteName();
$action = Route::currentRouteAction();

$url = route('profile', ['id' => 1]);

if (Request::route()->named('doctor')) {}

/**
 * Authentication Route
 */
Auth::routes();

/**
 * Normal Route
 */
Route::get('/posts/{post}/comments/{comment?}', function ($postId, $commentId = '1') {
	return view('welcome')->withName($name);
	return redirect('/login');
	return redirect()->route('profile');
})->where(['id' => '[0-9]+', 'name' => '[a-z]+']);

Route::view('/', 'welcome', ['name' => 'Taylor']);
Route::any('/', 'Controller@index');
Route::match(['get', 'post'], '/', 'Controller@index');
Route::redirect('/here', '/there');

/**
 * Route model inplict binding by key {user}
 */
Route::get('/posts/{post}', function (Post $post) { });
Route::get('/posts/{post:slug}', function (Post $post) { });

/**
 * Group Route
 */
Route::namespace('Admin')->middleware(['guest'])->prefix('admin')->name('admin.')->group(function () {
		Route::get('dashboard', 'Admin\AdminController@dashboard')->name('dashboard')
			->withoutMiddleware([AdminOnly::class, 'role:editor']);
	}
);

/**
 * Resource Route
 */
Route::resource('user', 'User\UserController', [
	'only' => ['index', 'create', 'store', 'show'],
	'except' => ['edit', 'update',  'destroy'],
	'names' => [
    	'index' => 'faq.all',
    	'create' => 'faq.new',
    	'store' => 'faq.save',
    	'show' => 'faq.view',
    	'edit' => 'faq.edit',
    	'update' => 'faq.update',
    	'destroy' => 'faq.delete',
	],
	'as' => 'prefix'
]);

/*
|--------------------------------------------------------------------------
| Ajax Routes
|--------------------------------------------------------------------------
 */
Route::any('ajax', 'AjaxController@index')->name('ajax');

/*
|--------------------------------------------------------------------------
| If no route matches
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    //
});
