# File
[symfony](https://github.com/symfony/symfony/blob/3.0/src/Symfony/Component/HttpFoundation/File/UploadedFile.php)

## Html
```php
<form enctype="multipart/form-data" method="POST">
</form>
```

## Package
> composer require spatie/laravel-image-optimizer

## Request
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

## Response
```php
# download
return response()->download($pathToFile);
return response()->download($pathToFile, $name, $headers);
return response()->download($pathToFile)->deleteFileAfterSend();

# display
return response()->file($pathToFile);
return response()->file($pathToFile, $headers);
```
