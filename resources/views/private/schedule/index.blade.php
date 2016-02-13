@extends('private.layout')

@section('content')
    <div class="header-content">
        <h2><i class="fa fa-home"></i>User</h2>
        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">You are here:</span>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="#">Content</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    Penjadwalan
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
                            <h3 class="panel-title">Tambah jadwal</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

                        {!! Form::open([
                            'route'     => 'schedule.store',
                            'class'     => 'app-form',
                            'id'        => 'form-' . $viewId,
                            'data-table' => $viewId . '-datatables'
                        ]) !!}

                        <div class="alert-wrapper"></div>

                        <div class="form-group">
                            <label for="task">Kegiatan</label>
                            <input type="text" name="task" id="task" placeholder="Kegiatan" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="date">Tanggal</label>
                            <input type="text" name="date" id="date" placeholder="Tanggal" class="form-control"/>
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
                            <h3 class="panel-title">Daftar jadwal</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

                        <table class="table table-striped table-bordered" id="{{$viewId}}-datatables">
                            <thead>
                            <tr>
                                <th>Kegiatan</th>
                                <th>Tanggal</th>
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
                    url: "{{route('schedule.data')}}"
                },
                columns: [
                    {data:'task',name:'task'},
                    {data:'date',name:'date'},
                    {data:'action',name:'action',orderable:false,searchable:false}
                ]
            });
        });
    </script>
@stop