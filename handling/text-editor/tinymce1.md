## Tinymce editor

==========setup======

// page setup
<!DOCTYPE html>   // doctype html
<html lang="en">
    <head>
        <meta charset="UTF-8"> 
    </head>
    
<link href="{{ asset('https://console.guidely.in/css/tinymce-codepen.min.css') }}" rel="stylesheet" />
<script src="{{ asset('https://console.guidely.in/js/tinymce.js') }}"></script>
<script src="{{ asset('https://console.guidely.in/js/tinymce-theme.min.js') }}"></script>

===============layout page===================

// set   = xhr.open('POST', "{{ route('admin.upload') }}");
    
// js setup
var tinyUploadPath = '';
var tinyConfig = {
        {{-- path_absolute: "{{ URL::to('/') }}/", --}}
        path_absolute: "https://guidelyassets.s3.ap-south-1.amazonaws.com/",
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
    

=================page========

<textarea class="form-control tinymceditor" name="description" id="description">$description</textarea>

<script>
$(document).ready(function () {
    
    tinyUploadPath = "courses";   // image path
     
    var allEditors = document.querySelectorAll('.tinymceditor');
    
    for (var i = 0; i < allEditors.length; ++i) {
        tinyConfig.selector = "#"+allEditors[i].id;
        tinymce.init(tinyConfig);
    }
});
</script>

==================save============


public function upload(Request $request)
    {
        $request->validate([ 'path' => 'required' ]);

        $path = Str::finish(config('filesystems.path.editor').$request->path, '/');
        $image = $this->uploadPhoto($request->file, $path);
        $imageWithPath = $path.$image;
        return response()->json([ 'location' => storage::disk('s3')->url($imageWithPath) ]);
    }
    
====================
