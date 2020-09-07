## Tinymce text editor

Other Reference link:
[summernote-wysiwyg-editor-with-image-upload](https://hdtuto.com/article/laravel-5-summernote-wysiwyg-editor-with-image-upload-example)

Other Reference link:
[upload-image-with-wysiwyg-editor-in.html](https://www.mchampaneri.in/2017/03/upload-image-with-wysiwyg-editor-in.html)

packages
[laravel-tinymce-simple-imageupload](https://github.com/petehouston/laravel-tinymce-simple-imageupload)

Route
> Route::post('/upload' , 'HomeController@upload')->name('upload');

Ajax header add
> 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

Controller
```php
public function upload(Request $request)
{
    $request->validate([ 'path' => 'required' ]);

    $imgpath = request()->file('file')->store("uploads/tinymce/$request->path", 'public');
    return response()->json(['location' => Storage::url($imgpath)]);
}
```

layout.blade.php
```php
var tinyUploadPath = '';
var tinyConfig = {
    path_absolute: "{{ URL::to('/') }}/",
    relative_urls: false,
    // selector: "#description",
    height: 250,
    // theme: 'modern',
    plugins: [
        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars code fullscreen',
        'insertdatetime media nonbreaking save table contextmenu directionality',
        'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help image code'
    ],
    toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
    toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
    image_advtab: true,
    templates: [
        { title: 'Test template 1', content: 'Test 1' },
        { title: 'Test template 2', content: 'Test 2' }
    ],
    content_css: [
        // '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
        // '//www.tinymce.com/css/codepen.min.css'
    ],
    images_reuse_filename: true,
    image_title: true,
    automatic_uploads: true,
    // images_upload_url: "{{ route('admin.upload') }}",
    images_upload_handler: function (blobInfo, success, failure) {
        var xhr, formData;
        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', "{{ route('admin.upload') }}");
        var token = '{{ csrf_token() }}';
        xhr.setRequestHeader("X-CSRF-Token", token);
        xhr.onload = function() {
            var json;
            if (xhr.status != 200) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }
            json = JSON.parse(xhr.responseText);
            if (!json || typeof json.location != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }
            success(json.location);
        };
        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        formData.append('path', tinyUploadPath);
        xhr.send(formData);
    },
    file_picker_types: 'image',
    file_picker_callback: function(cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');

        input.onchange = function() {
            var file = this.files[0];
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function() {
                var id = 'blobid' + (new Date()).getTime();
                var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);
                cb(blobInfo.blobUri(), { title: file.name });
            };
        };
        input.click();
    },
    setup: function(editor) {
        editor.on('change', function() { tinymce.triggerSave(); });
    }
}
```

form.blade.php
```php
<textarea class="form-control tinymceditor" id="description">
    {!! old('description', $model->description ?? null) !!}
</textarea>
```
```js
tinyUploadPath = "images";
var allEditors = document.querySelectorAll('.tinymceditor');
for (var i = 0; i < allEditors.length; ++i) {
    tinyConfig.selector = "#"+allEditors[i].id;
    tinymce.init(tinyConfig);
}

# get
var content = tinymce.get("texteditor").getContent();
var content = tinymce.get("texteditor").getContent({ format : 'html' });
var content = tinymce.get("texteditor").getContent({ format : 'raw' });

# set
tinyMCE.activeEditor.setContent(s);
tinyMCE.getInstanceById('textarea_id').setContent(s);
tinyMCE.get('my_textarea_id').setContent(my_value_to_set);
tinyMCE.get('texteditor').setContent(my_value_to_set);
tinyMCE.activeEditor.execCommand('mceInsertContent',false,Getname);

# when javascript add new editor btn clicked
createNewTinyEditor("description2");
function createNewTinyEditor(id) {
    tinyConfig.selector = '#'+id;
    tinymce.init(tinyConfig);
}
```
