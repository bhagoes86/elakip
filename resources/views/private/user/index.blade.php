@extends('private.layout')

@section('content')
    <div class="header-content">
        <h2><i class="fa fa-home"></i>User</h2>
        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">You are here:</span>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="#">Pengaturan</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    User
                </li>
            </ol>
        </div>
    </div>

    <div class="body-content animated fadeIn">
        <div class="row">
            <div class="col-md-4">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Tambah user</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

                        {!! Form::open([
                            'route'     => 'user.store',
                            'class'     => 'app-form',
                            'id'        => 'form-' . $viewId,
                            'data-table' => $viewId . '-datatables'
                        ]) !!}

                        <div class="alert-wrapper"></div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" placeholder="Username" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" placeholder="Email" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" id="name" placeholder="Real name" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="role">Role</label>
                            {!! Form::select('role_id', $roles, null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" placeholder="Password" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="password2">Password</label>
                            <input type="password" name="password2" id="password2" placeholder="Confirm password" class="form-control"/>
                        </div>

                        <button type="submit" class="btn btn-info btn-block btn-lg save">
                            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan
                        </button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Daftar user</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

                        <table class="table table-striped table-bordered" id="{{$viewId}}-datatables">
                            <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('private._partials.modal')
@stop

@section('scripts')
    <script src="{{asset('lib/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('lib/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
@stop

@section('styles')
    <link rel="stylesheet" href="{{asset('lib/datatables/media/css/dataTables.bootstrap.min.css')}}"/>
@stop

@section('script')
    <script type="text/javascript">
        $(function() {
            "use strict";

            var table = $('#{{$viewId}}-datatables').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{route('user.data')}}"
                },
                columns: [
                    {data:'name',name:'name'},
                    {data:'email',name:'email'},
                    {data:'role.name',name:'role.name'},
                    {data:'action',name:'action',orderable:false,searchable:false}
                ]
            });
        });
    </script>
@stop