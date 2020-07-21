# Route

## Web Routes
```php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Auth::routes();
Auth::routes(['register' => false]);
Auth::routes(['verify' => true]); // verify email by link

/*
|--------------------------------------------------------------------------
| Normal route
|--------------------------------------------------------------------------
*/
Route::get('/posts/{post}/comments/{comment?}', function ($postId, $commentId = '1') {
	//
})->where(['id' => '[0-9]+', 'name' => '[a-z]+']);

Route::view('/', 'welcome', ['name' => 'Taylor']);
Route::any('/', 'Controller@index');
Route::match(['get', 'post'], '/', 'Controller@index');
Route::redirect('/here', '/there');
Route::get('/{locale}/posts', '')->middleware('locale'); // pass default value

/*
|--------------------------------------------------------------------------
| Route model inplict binding by key {user}
|--------------------------------------------------------------------------
*/
Route::get('/posts/{post}', function (Post $post) { });
Route::get('/posts/{post:column}', function (Post $post) { }); // useful for column routes instead of id

/*
|--------------------------------------------------------------------------
| Group Route
|--------------------------------------------------------------------------
*/
Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
	Route::get('dashboard', 'Admin\AdminController@dashboard')->name('dashboard')
		->withoutMiddleware(['guest']);
})->middleware([AdminOnly::class, 'guest', 'role:editor']);
```

## Resource route (--resource --model=Photo)
```php
Route::resource('user', 'User\UserController', [
	'only' => ['index', 'create', 'store', 'show'],
	'except' => ['edit', 'update',  'destroy'],
	'names' => [
    	'index' => 'faq.all',
    	'create' => 'faq.new',
    	'store' => 'faq.save',
    	'show' => 'faq.view',
    	'edit' => 'faq.modify',
    	'update' => 'faq.alter',
    	'destroy' => 'faq.delete',
	],
	'as' => 'prefix'
])->names([
    'create' => 'faq.new'
])->parameters([
    // request()->route()->parameters()
    // request()->route('users')
    'users' => 'admin_user' // /users/{id} -> /users/{admin_user}
]);

Route::resources([
    'users' => 'UserController',
    'posts' => 'PostController'
]);

// Nested Resources: /photos/{photo}/comments/{comment}
// https://laraveldaily.com/nested-resource-controllers-and-routes-laravel-crud-example/
Route::resource('photos.comments', 'PhotoCommentController');

// It will skip the - /photos/{photo} url format on - show|edit|update|destroy
Route::resource('photos.comments', 'PhotoCommentController')->shallow();
```

| Verb	      | URI			   		 | Action	     | Name		      |
| :---        |    	    :----:       |          ---: |           ---: |
| GET	      | /photos        		 | index		 | photos.index   |
| GET		  | /photos/create 		 | create        | photos.create  |
| POST		  | /photos	store  		 | store         | photos.store   |
| GET		  | /photos/{photo} 	 | show          | photos.show    |
| GET		  | /photos/{photo}/edit | edit	         | photos.edit    |
| PUT/PATCH	  | /photos/{photo} 	 | update        | photos.update  |
| DELETE	  | /photos/{photo} 	 | destroy       | photos.destroy |

## API (--api)
```php
Route::apiResource('photos', 'PhotoController');
```

```php
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

/*
|--------------------------------------------------------------------------
| Cache Control Middleware
|--------------------------------------------------------------------------
*/
Route::middleware('cache.headers:public;max_age=2628000;etag')->group(function () {
    Route::get('privacy', 'Controller');
    Route::get('terms', 'Controller');
});

/*
|--------------------------------------------------------------------------
| dynamic subdomain name
|--------------------------------------------------------------------------
*/
Route::domain('{username}.workspace.com')->group(function () {
    Route::get('user/{id}', function ($username, $id) {
    });
});

/*
|--------------------------------------------------------------------------
| livewire
|--------------------------------------------------------------------------
*/
Route::livewire('/register', 'auth.register')->layout('layouts.app');
```
