@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.candidate.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.candidates.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.candidate.fields.id') }}
                        </th>
                        <td>
                            {{ $candidate->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.candidate.fields.text') }}
                        </th>
                        <td>
                            {{ $candidate->text }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.candidate.fields.email') }}
                        </th>
                        <td>
                            {{ $candidate->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.candidate.fields.textarea') }}
                        </th>
                        <td>
                            {!! $candidate->textarea !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.candidate.fields.password') }}
                        </th>
                        <td>
                            ********
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.candidate.fields.radio') }}
                        </th>
                        <td>
                            {{ App\Candidate::RADIO_RADIO[$candidate->radio] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.candidate.fields.select') }}
                        </th>
                        <td>
                            {{ App\Candidate::SELECT_SELECT[$candidate->select] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.candidate.fields.checkbox') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $candidate->checkbox ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.candidate.fields.integer') }}
                        </th>
                        <td>
                            {{ $candidate->integer }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.candidate.fields.float') }}
                        </th>
                        <td>
                            {{ $candidate->float }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.candidate.fields.money') }}
                        </th>
                        <td>
                            {{ $candidate->money }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.candidate.fields.date') }}
                        </th>
                        <td>
                            {{ $candidate->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.candidate.fields.date_time') }}
                        </th>
                        <td>
                            {{ $candidate->date_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.candidate.fields.time') }}
                        </th>
                        <td>
                            {{ $candidate->time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.candidate.fields.file') }}
                        </th>
                        <td>
                            @if($candidate->file)
                                <a href="{{ $candidate->file->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.candidate.fields.image') }}
                        </th>
                        <td>
                            @if($candidate->image)
                                <a href="{{ $candidate->image->getUrl() }}" target="_blank">
                                    <img src="{{ $candidate->image->getUrl('thumb') }}" width="50px" height="50px">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.candidates.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
