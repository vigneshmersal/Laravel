# Request

# GET
```php
# Retrieve all data
$request->all();
$request->input();
$request->query();

# Retrieve individual data
$request->name;
$request->get('name');
$request->input('name', 'default');

# Retrieve data from only query string -> ?name=vignesh
$request->query('name', 'default');

# Retrieve checkboxes deal with either true (or) 1
$archived = $request->boolean('archived');

# It will useful while save the bulk records
$input = $request->only(['username', 'password']);
$input = $request->except(['credit_card']);

# Retrieving JSON Input Values -> Content-Type: application/json
$name = $request->input('user.name');

# When working with forms that contain array inputs, use "dot" notation to access the arrays:
$request->input('products.0.name'); # get individual data
$request->input('products.*.name'); # get array of data
```

## check condition
```php
# check var exist in the query string
if ($request->exists('name')) { }

# check var exist with the val
if ($request->has('name')) { }
if ($request->has(['name', 'email'])) { }
if ($request->hasAny(['name', 'email'])) { }
if ($request->filled('name')) { } // present & not empty
if ($request->missing('name')) { } // absent

# check view exist
if (View::exists('emails.customer')) { }
```

## Old data flash session
```php
# save the current input to the session
$request->flash();
$request->flashOnly(['username', 'email']);
$request->flashExcept('password');

# Retrieving Old Input
$username = $request->old('username');

// If validation failed redirect with flash data
return redirect('form')->withInput(
    $request->except('password')
);
```

## File
```php
# Retrieving Uploaded Files
$file = $request->file('photo');
$file = $request->photo;

# check request photo exist
if ($request->hasFile('photo')) { }
if ($request->file('photo')->isValid()) { } // Validating Successful Uploads

# get path info
$path = $request->photo->path();
$extension = $request->photo->extension();

# store a file
$path = $request->photo->store('images');
$path = $request->photo->store('images', 's3'); // cloud awazon s3 store
# Rename and store a file
$path = $request->photo->storeAs('images', 'filename.jpg');
$path = $request->photo->storeAs('images', 'filename.jpg', 's3');
```
