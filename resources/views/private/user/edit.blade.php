@extends('private.layout')

@section('content')
    <div class="header-content">
        <h2><i class="fa fa-home"></i>Edit user {{Auth::user()->name}}</h2>
        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">You are here:</span>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="#">Pengaturan</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    Year
                </li>
            </ol>
        </div>
    </div>

    <div class="body-content animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Basic info</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    @foreach($errors->all() as $error)
                        <span>{{$error}}</span>
                    @endforeach

                    <div class="panel-body">
                        {!! Form::model($user, [
                            'route' => ['user.update', $user->id],
                            'method' => 'PUT',

                            ]) !!}

                        {{--<div class="alert-wrapper"></div>--}}

                        <div class="form-group">
                            <label for="username">Username</label>
                            {!! Form::text('username', null, ['id' => 'username', 'placeholder' => 'Username', 'class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            {!! Form::email('email', null, ['id' => 'email', 'placeholder' => 'Email', 'class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            <label for="name">Real name</label>
                            {!! Form::text('name', null, ['id' => 'name', 'placeholder' => 'Real name', 'class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            <label for="role">Role</label>
                            {!! Form::select('role_id', $roles, $selectedRole, ['class' => 'form-control']) !!}
                        </div>

                        <button type="submit" class="btn btn-info">
                            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update
                        </button>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-md-12">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Password</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        {!! Form::open([
                            'route' => ['user.password.update', $user->id],
                            'method' => 'PUT',

                            ]) !!}

                        {{--<div class="alert-wrapper"></div>--}}

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" class="form-control" placeholder="Password" name="password"/>
                        </div>

                        <div class="form-group">
                            <label for="password2">Confirm</label>
                            <input type="password" id="password2" class="form-control" placeholder="Confirm password" name="password2"/>
                        </div>

                        <button type="submit" class="btn btn-info">
                            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update
                        </button>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>

    </script>
@stop