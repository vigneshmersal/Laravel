@extends('backEnd.layouts.app')

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <div class="card-header-right">
                <i class="icofont icofont-spinner-alt-5"></i>
            </div>
        </div>

        <div class="card-block">
            <h4 class="sub-title">Admin List</h4>

            @include('components.success')

            <div class="table-responsive dt-responsive">
                <table id="dt-admin" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $loop->index + $users->firstItem() }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->mobile }}</td>
                                <td>
                                    <span class="label {{ $user->status ? 'label-success' : 'label-danger' }}">{{ $user->active }}</span>
                                </td>
                                <td>
                                    <div class="text-nowrap">
                                        <a href="{{ route('user.edit', $user) }}" class="btn btn-sm btn-info"> Edit </a>

                                        {{ Form::open([
                                            'route' => ['candidate.destroy', $user],
                                            'style' => 'display:inline',
                                            'onsubmit' => "return confirm('Do you really want to Delete it?');",
                                            'class' => 'pull-right'])
                                        }}
                                            @method("DELETE")
                                            {{ Form::submit('Delete', ['class' => 'btn btn-sm btn-danger']) }}
                                        {{ Form::close() }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-5">
                    <div class="dataTables_info" id="dt-admin_info" role="status" aria-live="polite">Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries</div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7 float-right">
                    {!! $users->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
