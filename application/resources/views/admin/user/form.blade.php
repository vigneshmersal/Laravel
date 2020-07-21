@extends('backEnd.layouts.app')

@section('content')
<div class="col-sm-10">
    <div class="card">
        <div class="card-header">
            <div class="card-header-right">
                <i class="icofont icofont-spinner-alt-5"></i>
            </div>
        </div>

        <div class="card-block">
            <h4 class="sub-title">Admin User Form</h4>

            @include('components.errors')

            @isset($user)
                {!! Form::open([ 'route' => ['user.update', $user], 'files' => true ]) !!}
                @method('patch')
                {!! Form::hidden('id', $user->id, []) !!}
            @else
                {!! Form::open([ 'route' => ['user.store'], 'files' => true ]) !!}
            @endif

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        {!! Form::text('name', old('name', $user->name ?? null), [
                            'class' => 'form-control',
                            'required' => true
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        {!! Form::email('email', old('email', $user->email ?? null), [
                            'class' => 'form-control',
                            'required' => true
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        {!! Form::password('password', [
                            'class' => 'form-control',
                            'required' => isset($user) ? false : true
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Mobile</label>
                    <div class="col-sm-10">
                        {!! Form::text('mobile', old('mobile', $user->mobile ?? null), [
                            'class' => 'form-control',
                            'required' => true,
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Date Of Birth</label>
                    <div class="col-sm-10">
                        {!! Form::date('dob', old('dob', $user->dob ?? null), [
                            'class' => 'form-control',
                            'required' => true
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-10">
                        {!! Form::textarea('address', old('address', $user->address ?? null), [
                            'class' => 'form-control',
                            'rows' => 5, 'cols' => 5
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Designation</label>
                    <div class="col-sm-10">
                        {!! Form::text('employee_role', old('employee_role', $user->employee_role ?? null), [
                            'class' => 'form-control',
                            'required' => true
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Employee Team</label>
                    <div class="col-sm-10">
                        {{ Form::select('employee_team', [
                                ''=>'Select',
                                '1'=>'Product Making Team',
                                '2'=>'SEO Team',
                                '3'=>'Question Adding Team',
                                '4'=>'Comments Team',
                                '5'=>'Support Team',
                                '6'=>'English Content Developing Team',
                                '7'=>"Quant's Content Developing Team",
                                '8'=>'Reasoning Content Developing Team',
                                '9'=>'Current Affaris Content Developing Team',
                                '10'=>'SSC Content Developing Team',
                                '11'=>'Technical Team',
                            ], old('employee_team', $user->employee_team ?? null), [
                                'class'=>'form-control',
                                'required'=>true
                            ])
                        }}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Date Of Joining</label>
                    <div class="col-sm-10">
                        {!! Form::date('employee_join_date', old('employee_join_date', $user->employee_join_date ?? null), [
                            'class' => 'form-control',
                            'required' => true
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Employee Rights</label>
                    <div class="col-sm-10">
                        {{ Form::select('user_rights[]', [
                                '1'=>'All',
                                '2'=>'Dashboard',
                                '3'=>'Admin User',
                            ], old('user_rights[]', explode(",", $user->user_rights ?? null)), [
                                'class' => 'js-example-basic-multiple col-sm-12',
                                'required' => true,
                                'multiple' => true
                            ])
                        }}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Profile Photo</label>
                    <div class="col-sm-10">
                        {!! Form::file('profile_image', [ 'class' => 'form-control' ]) !!}
                        @isset($user)
                            @if($user->profile_image != "")
                                <br><img class="img-fluid" width="200" height="200" src="{{ asset('img/adminuser/'.$user->profile_image) }}" alt="User profile">
                            @endif
                        @endisset
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        {{ Form::select('status', [
                                '1'=>'Active',
                                '0'=>'Non Active',
                            ], old('status', $user->status ?? null), [
                                'class'=>'form-control',
                                'required'=>true
                            ])
                        }}
                    </div>
                </div>

                <div class="col-md-10" style="text-align: center;">
                    {!! Form::submit('Save', [ 'class' => 'btn btn-success' ]) !!}
                    <a href="#" class="btn btn-danger">Cancel</a>
                </div>

            {!! Form::close() !!}

        </div>
    </div>
</div>
@endsection
