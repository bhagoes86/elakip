@extends('private.layout')

@section('content')

    <div class="header-content">
        <h2><i class="fa fa-home"></i>Program {{$program->name}}</h2>
    </div>

    <div class="body-content animated fadeIn">

        <div class="row">

            <div class="col-md-12">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Detail</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        <table class="table table-condensed table-striped">
                            <tr>
                                <th>Periode</th>
                                <td>: <a href="{{route('renstra.program.index', [$program->id])}}">{{$program->plan->period->year_begin}} - {{$program->plan->period->year_end}}</a></td>
                            </tr>
                            <tr>
                                <th>Program</th>
                                <td>: <strong>{{$program->name}}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-4">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Sasaran program</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        {!! Form::open([
                            'route'    => ['renstra.program.sasaran.store', $program->plan->id, $program->id],
                            'class'     => 'app-form',
                            'id'        => 'form-' . $viewId,
                            'data-table' => $viewId . '-sasaran-datatables'
                        ]) !!}

                        <div class="alert-wrapper"></div>

                        <div class="form-group">
                            <label for="name">Nama sasaran</label>
                            <textarea name="name" id="name" placeholder="Nama sasaran program" class="form-control autosize"></textarea>
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
                            <h3 class="panel-title">Daftar sasaran program</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

                        <table class="table table-striped table-bordered" id="{{$viewId}}-sasaran-datatables">
                            <thead>
                            <tr>
                                <th>Sasaran</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <hr/>
        <div class="row">

            <div class="col-md-4">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Kegiatan program</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        {!! Form::open([
                            'route'    => ['renstra.program.kegiatan.store', $program->plan->id, $program->id],
                            'class'     => 'app-form',
                            'id'        => 'form-' . $viewId,
                            'data-table' => $viewId . '-kegiatan-datatables'
                        ]) !!}

                        <div class="alert-wrapper"></div>

                        <div class="form-group">
                            <label for="name">Unit</label>
                            {!! Form::select('unit_id', $units, null, ['class' => 'form-control', 'placeholder' => '[ Pilih Unit ]']) !!}
                        </div>

                        <div class="form-group">
                            <label for="name">Nama kegiatan</label>
                            <textarea name="name" id="name" placeholder="Nama sasaran program" class="form-control autosize"></textarea>
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
                            <h3 class="panel-title">Daftar kegiatan program</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

                        <table class="table table-striped table-bordered" id="{{$viewId}}-kegiatan-datatables">
                            <thead>
                            <tr>
                                <th>Unit</th>
                                <th>Sasaran</th>
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
    <script src="{{asset('lib/autosize/dist/autosize.min.js')}}"></script>
@stop

@section('styles')
    <link rel="stylesheet" href="{{asset('lib/datatables/media/css/dataTables.bootstrap.min.css')}}"/>
@stop

@section('script')
    <script type="text/javascript">
        $(function() {
            "use strict";

            var table = $('#{{$viewId}}-sasaran-datatables').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{route('renstra.program.sasaran.data')}}",
                    data: function(d) {
                        d.program = {{$program->id}};
                        d.plan = {{$program->plan->id}};
                        d.type  = 'program';
                    }
                },
                columns: [
                    {data:'name',name:'name'},
                    {data:'action',name:'action', orderable:false, searchable:false}
                ]
            });

            var table = $('#{{$viewId}}-kegiatan-datatables').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{route('renstra.program.kegiatan.data')}}",
                    data: function(d) {
                        d.program = {{$program->id}};
                        d.plan = {{$program->plan->id}};
                        d.type  = 'activity';
                    }
                },
                columns: [
                    {data:'unit.name',name:'unit.name'},
                    {data:'name',name:'name'},
                    {data:'action',name:'action', orderable:false, searchable:false}
                ]
            });

            autosize($('textarea'));

        });
    </script>
@stop