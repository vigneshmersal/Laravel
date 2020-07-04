@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.candidate.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.candidates.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="text">{{ trans('cruds.candidate.fields.text') }}</label>
                <input class="form-control {{ $errors->has('text') ? 'is-invalid' : '' }}" type="text" name="text" id="text" value="{{ old('text', 'vignesh') }}" required>
                @if($errors->has('text'))
                    <div class="invalid-feedback">
                        {{ $errors->first('text') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.text_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="email">{{ trans('cruds.candidate.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}" required>
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="textarea">{{ trans('cruds.candidate.fields.textarea') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('textarea') ? 'is-invalid' : '' }}" name="textarea" id="textarea">{!! old('textarea') !!}</textarea>
                @if($errors->has('textarea'))
                    <div class="invalid-feedback">
                        {{ $errors->first('textarea') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.textarea_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="password">{{ trans('cruds.candidate.fields.password') }}</label>
                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password">
                @if($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.password_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.candidate.fields.radio') }}</label>
                @foreach(App\Candidate::RADIO_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('radio') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="radio_{{ $key }}" name="radio" value="{{ $key }}" {{ old('radio', 'radio1') === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="radio_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('radio'))
                    <div class="invalid-feedback">
                        {{ $errors->first('radio') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.radio_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.candidate.fields.select') }}</label>
                <select class="form-control {{ $errors->has('select') ? 'is-invalid' : '' }}" name="select" id="select">
                    <option value disabled {{ old('select', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Candidate::SELECT_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('select', 'select1') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('select'))
                    <div class="invalid-feedback">
                        {{ $errors->first('select') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.select_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('checkbox') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="checkbox" value="0">
                    <input class="form-check-input" type="checkbox" name="checkbox" id="checkbox" value="1" {{ old('checkbox', 0) == 1 || old('checkbox') === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="checkbox">{{ trans('cruds.candidate.fields.checkbox') }}</label>
                </div>
                @if($errors->has('checkbox'))
                    <div class="invalid-feedback">
                        {{ $errors->first('checkbox') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.checkbox_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="integer">{{ trans('cruds.candidate.fields.integer') }}</label>
                <input class="form-control {{ $errors->has('integer') ? 'is-invalid' : '' }}" type="number" name="integer" id="integer" value="{{ old('integer', '1') }}" step="1">
                @if($errors->has('integer'))
                    <div class="invalid-feedback">
                        {{ $errors->first('integer') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.integer_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="float">{{ trans('cruds.candidate.fields.float') }}</label>
                <input class="form-control {{ $errors->has('float') ? 'is-invalid' : '' }}" type="number" name="float" id="float" value="{{ old('float', '5') }}" step="0.01" min="1" max="100">
                @if($errors->has('float'))
                    <div class="invalid-feedback">
                        {{ $errors->first('float') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.float_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="money">{{ trans('cruds.candidate.fields.money') }}</label>
                <input class="form-control {{ $errors->has('money') ? 'is-invalid' : '' }}" type="number" name="money" id="money" value="{{ old('money', '10') }}" step="0.01">
                @if($errors->has('money'))
                    <div class="invalid-feedback">
                        {{ $errors->first('money') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.money_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date">{{ trans('cruds.candidate.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date') }}">
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_time">{{ trans('cruds.candidate.fields.date_time') }}</label>
                <input class="form-control datetime {{ $errors->has('date_time') ? 'is-invalid' : '' }}" type="text" name="date_time" id="date_time" value="{{ old('date_time') }}">
                @if($errors->has('date_time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.date_time_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time">{{ trans('cruds.candidate.fields.time') }}</label>
                <input class="form-control timepicker {{ $errors->has('time') ? 'is-invalid' : '' }}" type="text" name="time" id="time" value="{{ old('time') }}">
                @if($errors->has('time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.time_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="file">{{ trans('cruds.candidate.fields.file') }}</label>
                <div class="needsclick dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}" id="file-dropzone">
                </div>
                @if($errors->has('file'))
                    <div class="invalid-feedback">
                        {{ $errors->first('file') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.file_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.candidate.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.candidate.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/admin/candidates/ckmedia', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', {{ $candidate->id ?? 0 }});
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

<script>
    Dropzone.options.fileDropzone = {
    url: '{{ route('admin.candidates.storeMedia') }}',
    maxFilesize: 5, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').find('input[name="file"]').remove()
      $('form').append('<input type="hidden" name="file" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="file"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($candidate) && $candidate->file)
      var file = {!! json_encode($candidate->file) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="file" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    Dropzone.options.imageDropzone = {
    url: '{{ route('admin.candidates.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="image"]').remove()
      $('form').append('<input type="hidden" name="image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($candidate) && $candidate->image)
      var file = {!! json_encode($candidate->image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, '{{ $candidate->image->getUrl('thumb') }}')
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}
</script>
@endsection
