# Upload Image using ajax

```php
Route::post('/upload' , 'HomeController@upload')->name('upload');
```

```html
<form id="header_image_frm" method="POST" action="">
    <input type="file" name="image" id="image" value="Upload Header Image">
</form>

@section('scripts')
@parent
    <script>
      $(document).ready(function() {
        $('#image').change(function() {
            let formData = new FormData($('#header_image_frm')[0]);
            // let file = $('input[type=file]')[0].files[0];
            // formData.append('file', file, file.name);
            $.ajax({
                url: '{{ route("upload") }}',
                // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                contentType: false,
                processData: false,
                cache: false,
                data: formData,
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
