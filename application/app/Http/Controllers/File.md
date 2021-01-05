# File
[symfony](https://github.com/symfony/symfony/blob/3.0/src/Symfony/Component/HttpFoundation/File/UploadedFile.php)

https://medium.com/@sehmbimanvir/laravel-upload-files-to-amazon-s3-a17d013f53ce

## Html
```php
<form enctype="multipart/form-data" method="POST">
</form>
```

## Package
> composer require spatie/laravel-image-optimizer

## Request
```php
Storage::disk('public')->makeDirectory('adminuser', 0775, true, true);

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
$path = $request->photo->store('images', $disk); // $disk= 's3', 'local', 'public'

# Rename and store a file
$path = $request->photo->storeAs('images', 'filename.jpg');
$path = $request->photo->storeAs('images', 'filename.jpg', 's3');

# Delete a file
Storage::delete(['path/file.png']);
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

## Delete
```php
use Illuminate\Support\Facades\File;

$image_path = public_path("images/news/".$news->photo);
if(file_exists($image_path)){
	File::delete( $image_path);
	File::delete($file1, $file2);
	File::delete([$file1, $file2]);
}

Storage::delete('public/'.$image_path);
Storage::disk('public')->delete($image_path);

// PHP
unlink(app_path().'/images/news/'.$news->photo);
```

## s3
https://stackoverflow.com/questions/48783020/laravel-s3-image-upload-creates-a-folder-with-the-filename-automatically

```php
composer require league/flysystem-aws-s3-v3
$exists = Storage::disk('s3')->exists('file.jpg');
>>> $path = Storage::disk('s3')->put('images/', 'dgd');
$missing = Storage::disk('s3')->missing('file.jpg');

$contents = Storage::get('file.jpg');
return Storage::download('file.jpg');
return Storage::download('file.jpg', $name, $headers);
Storage::disk('s3')->delete('folder_path/file_name.jpg');

$url = Storage::url('file.jpg');
$path = $request->file('avatar')->store(
    'avatars/'.$request->user()->id, 's3'
);

public function moveImg($id, $tempDir)
{
    $images = Storage::disk('s3')->allFiles('temp/' . $tempDir);
    foreach($images as $img)
    {
        $moveTo = str_replace('temp/' . $tempDir, 'property/' . $id, $img);
        Storage::disk('s3')->move($img, $moveTo);
    }
}
```

## File save content

```php
File::append(
    storage_path('/logs/query.log'),
    $query->sql.' ['.implode(', ', $query->bindings).'] - '.$time.PHP_EOL
);
```
