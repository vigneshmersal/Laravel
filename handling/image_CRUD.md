# Image
```php
# migration
$table->string('image')->nullable()

# validation
'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
'photo' => 'dimensions:max_width=4096,max_height=4096'
'file'  => 'required|mimes:doc,docx,pdf,txt|max:2048',

# Trait
/**
 * [upload photo]
 */
public function uploadPhoto($image, $path)
{
	$extension = $image->getClientOriginalExtension();
	$imageName = time().'.'.$extension;
	$image->move( public_path($path), $imageName );
	return $imageName;
}

/**
 * [upload photo from external url]
 * $image = 'https://i.stack.imgur.com/koFpQ.png';
 * $image = 'http://www.google.co.in/intl/en_com/images/srpr/logo1w.png';
 */
public function uploadExternalImageURL($image, $path)
{
    $uploadedImageName = basename($image); // koFpQ.png
	$extension = \File::extension($image); // png
    $imageName = time().'.'.$extension;    // 2344.png
	\Image::make($image)->save(public_path($path . $imageName));
    return $imageName;
}

# Model
public function getImageAttribute($value)
{
    if ($value) {
        return config('filesystems.path.users').$value;
    }
    return null;
}

# index HTML page
<td><img src="{{ asset($user->image) }}" class="img-thumbnail" width="75" /></td>

# create HTML page
<input type="file" name="image" />

# edit HTML page
<div class="form-group">
    <label for="image">{{ trans('cruds.candidate.fields.image') }}</label>
	<div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
		<input type="file" name="image" />
		<input type="hidden" name="hidden_image" value="{{ $user->image }}" />
		@isset($user)
		    @if($user->image)
		        <img src="{{ asset($user->image) }}" class="img-thumbnail" width="100" alt="User profile">
		    @endif
		@endisset
	</div>
	@if($errors->has('image'))
	    <div class="invalid-feedback">
	        {{ $errors->first('image') }}
	    </div>
	@endif
	<span class="help-block">{{ trans('cruds.candidate.fields.image_helper') }}</span>
</div>

# show HTML page
<img src="{{ URL::to('/') }}/images/{{ $data->image }}" class="img-thumbnail" />
@if($user->image)
    <a href="{{ asset($user->image) }}" target="_blank">
        <img src="{{ asset($user->image) }}" width="100px" height="100px">
    </a>
@endif

# controller
if ($request->has('image')) {
    $image = $this->uploadPhoto($request->image, config('filesystems.path.users'));
    $user->image = $image;
    $user->save();
}
```
