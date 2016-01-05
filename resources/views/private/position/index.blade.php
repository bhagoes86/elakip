@extends('private.layout')

@section('content')
    <div class="header-content">
        <h2><i class="fa fa-home"></i>Jabatan user</h2>
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
            <div class="col-md-4">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Jabatan baru</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

                        {!! Form::open([
                            'route'     => 'position.store',
                            'class'     => 'app-form',
                            'id'        => 'form-' . $viewId,
                            'data-table' => $viewId . '-datatables'
                        ]) !!}

                        <div class="alert-wrapper"></div>

                        <div class="form-group">
                            <label for="year" >Year</label>
                            {!! Form::select('year', $years, null, ['id' => 'year', 'class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            <label for="user" >Name</label>
                            {{--{!! Form::select('user', $users, null, ['id' => 'user', 'class' => 'form-control']) !!}--}}
                            <select id="user" class="form-control" name="user">
                                <option>... Loading ...</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="unit" >Unit</label>
                            {!! Form::select('unit', $units, null, ['id' => 'unit', 'class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            <label for="position" >Posisi</label>
                            {!! Form::text('position', null, ['id' => 'position', 'class' => 'form-control']) !!}
                        </div>


                        <button type="submit" class="btn btn-info btn-block btn-lg save">
                            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save
                        </button>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Jabatan user per tahun</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">



                        <div class="row mbot-15">
                            <div class="col-md-6">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label for="year" class="col-sm-2 control-label">Year</label>
                                        <div class="col-sm-10">
                                            {!! Form::select('year', $years, null, [
                                                'class' => 'form-control',
                                                'id'    => 'year-filter'
                                            ]) !!}

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label for="unit" class="col-sm-2 control-label">Unit</label>
                                        <div class="col-sm-10">
                                            {!! Form::select('unit', $units, null, [
                                                'class' => 'form-control',
                                                'id'    => 'unit-filter'
                                            ]) !!}

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered" id="{{$viewId}}-datatables">
                                    <thead>
                                    <tr>
                                        <th>Tahun</th>
                                        <th>Nama</th>
                                        <th>Unit</th>
                                        <th>Posisi</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>

                            </div>
                        </div>
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

            var $year     = $('#year'),
                    yearVal = $year.val(),
                    $yearFilter = $('#year-filter'),
                    yearFilterVal = $yearFilter.val();

            var table = $('#{{$viewId}}-datatables').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{route('position.data')}}",
                    data: function (d) {
                        d.year = $('#year-filter').val();
                    }
                },
                columns: [
                    {data:'year',name:'year'},
                    {data:'user.name',name:'user.name'},
                    {data:'unit.name',name:'unit.name'},
                    {data:'position',name:'position'},
                    {data:'action',name:'action', orderable:false, searchable:false}
                ]
            });

            $.get("{{url('position/user/not:')}}" + yearVal, function (r) {
                $('#user').html(r);
            });

            $yearFilter.change(function () {
                var $this = $(this),
                        value = $this.val();

                table.ajax.reload();
            });

            $year.change(function () {
                var $this = $(this),
                        value = $this.val();

                $('#user').html('<option>... Loading ...</option>');

                $.get("{{url('position/user/not:')}}" + value, function (r) {
                    $('#user').html(r);
                });
            });

            $('#form-{{$viewId}}').submit(function (e) {
                var value = $('#year').val();

                $('#user').html('<option>... Loading ...</option>');

                $.get("{{url('position/user/not:')}}" + value, function (r) {
                    $('#user').html(r);
                });
            });
        });
    </script>
@stop