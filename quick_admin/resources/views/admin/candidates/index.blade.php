@extends('layouts.admin')
@section('content')
@can('candidate_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.candidates.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.candidate.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.candidate.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Candidate">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.candidate.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.candidate.fields.text') }}
                    </th>
                    <th>
                        {{ trans('cruds.candidate.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.candidate.fields.radio') }}
                    </th>
                    <th>
                        {{ trans('cruds.candidate.fields.select') }}
                    </th>
                    <th>
                        {{ trans('cruds.candidate.fields.checkbox') }}
                    </th>
                    <th>
                        {{ trans('cruds.candidate.fields.integer') }}
                    </th>
                    <th>
                        {{ trans('cruds.candidate.fields.float') }}
                    </th>
                    <th>
                        {{ trans('cruds.candidate.fields.money') }}
                    </th>
                    <th>
                        {{ trans('cruds.candidate.fields.date') }}
                    </th>
                    <th>
                        {{ trans('cruds.candidate.fields.date_time') }}
                    </th>
                    <th>
                        {{ trans('cruds.candidate.fields.time') }}
                    </th>
                    <th>
                        {{ trans('cruds.candidate.fields.file') }}
                    </th>
                    <th>
                        {{ trans('cruds.candidate.fields.image') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Candidate::RADIO_RADIO as $key => $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Candidate::SELECT_SELECT as $key => $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('candidate_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.candidates.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.candidates.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'text', name: 'text' },
{ data: 'email', name: 'email' },
{ data: 'radio', name: 'radio' },
{ data: 'select', name: 'select' },
{ data: 'checkbox', name: 'checkbox' },
{ data: 'integer', name: 'integer' },
{ data: 'float', name: 'float' },
{ data: 'money', name: 'money' },
{ data: 'date', name: 'date' },
{ data: 'date_time', name: 'date_time' },
{ data: 'time', name: 'time' },
{ data: 'file', name: 'file', sortable: false, searchable: false },
{ data: 'image', name: 'image', sortable: false, searchable: false },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  };
  let table = $('.datatable-Candidate').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  $('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value
      table
        .column($(this).parent().index())
        .search(value, strict)
        .draw()
  });
});

</script>
@endsection
