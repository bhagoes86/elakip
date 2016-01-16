@extends('private.layout')

@section('content')

    <div class="header-content">
        <h2><i class="fa fa-home"></i>Profil</h2>
    </div>

    <div class="body-content animated fadeIn">

       {{-- @if ($errors->has())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif--}}

        <div class="row">

            <div class="col-md-12">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Informasi dasar</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        {!! Form::model($user, ['route' => 'profile.update', 'method' => 'PUT', 'files' => true]) !!}
                        <div class="form-group @if ($errors->has('username')) has-error @endif">
                            <label for="username">Username</label>
                            {!! Form::text('username', null, ['class' => 'form-control', 'disabled']) !!}
                            @if ($errors->has('username')) <p class="help-block">{{ $errors->first('username') }}</p> @endif

                        </div>
                        <div class="form-group @if ($errors->has('name')) has-error @endif">
                            <label for="name">Nama lengkap</label>
                            {!! Form::text('name', Input::old('name'), ['class' => 'form-control']) !!}
                            @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif

                        </div>
                        <div class="form-group @if ($errors->has('email')) has-error @endif">
                            <label for="email">Email</label>
                            {!! Form::text('email', Input::old('email'), ['class' => 'form-control']) !!}
                            @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif

                        </div>

                        <div class="form-group">
                            <label for="pp">Profile Picture</label>
                            <input type="file" id="pp" name="profile-picture">
                            <p class="help-block">Profile Picture.</p>
                        </div>

                        <button type="submit" class="btn btn-info">
                            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save
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
                        {!! Form::open(['route' => 'profile.password.update', 'method' => 'PUT']) !!}

                        <div class="form-group @if ($errors->has('password')) has-error @endif">
                            <label for="password">Password</label>
                            {!! Form::password('password', ['class' => 'form-control']) !!}
                            @if ($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
                        </div>

                        <div class="form-group @if ($errors->has('password')) has-error @endif">
                            <label for="password-confirm">Konfirmasi password</label>
                            {!! Form::password('password-confirm', ['class' => 'form-control']) !!}
                            @if ($errors->has('password-confirm')) <p class="help-block">{{ $errors->first('password-confirm') }}</p> @endif

                        </div>

                        <button type="submit" class="btn btn-info">
                            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update password
                        </button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>


    </div>
@stop