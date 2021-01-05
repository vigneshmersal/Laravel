# Upload Image using ajax

```php
Route::post('/upload' , 'HomeController@upload')->name('upload');
```

```html
<form id="header_image_frm" method="POST" action="{{url}}" enctype="multipart/form-data">
	<input type="file" name="image" id="image" value="Upload Header Image">
</form>

@section('scripts')
@parent
	<script>
	  $(document).ready(function() {
		$('#image').on('change',function(ev){
			var file=this.files[0];

			// check image mime type
			var imgtype=filedata.type;
			var match=['image/jpeg','image/jpg'];
			if(!(imgtype==match[0])||(imgtype==match[1])){
				$('#mgs_ta').html('<p style="color:red">Plz select a valid type image..only jpg jpeg allowed</p>');
			}

			//---image preview
			var reader=new FileReader();
			reader.onload=function(ev){
				$('#img_preview').html('<img src="'+ev.target.result+'" width="100" class="img-thumbnail">');
			}
			reader.readAsDataURL(file);

			// var formData=new FormData();
			// formData.append('file',this.files[0]);

			let formData = new FormData($('#header_image_frm')[0]);
			formData.append('path', 'images/notification/');
			// let file = $('input[type=file]')[0].files[0];
			// formData.append('file', file, file.name);
			$.ajax({
				data: formData,
				url: '{{ route("upload") }}',
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				// async:true,
				type: 'POST',
				contentType: false, processData: false, cache: false,
				success: function(data) {
					console.log(data);
				},
				error: function(data) {
					console.log(data);
				}
			});
		});
	  });
	</script>
@endsection
```

```php
public function upload(Request $request)
{
	\Log::info([ $request->all() ]);
	try {
		$candidate = auth()->user();

		// $request->validate([]);
		$validator = Validator::make($request->all(), [
			'image'    => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		]);

		if ($validator->fails()) {
			return \ApiHelper::error($validator->errors());
		}

		$image = $this->uploadPhoto($request->image, config('filesystems.path.candidates'));
		$candidate->image = $image;
		$candidate->save();

		return new CandidateResource($candidate);
	} catch (Exception | Throwable $ex) {
		return ApiHelper::exception($ex);
	}
}
```
