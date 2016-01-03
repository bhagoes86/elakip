@extends('private.layout')

@section('content')

    <div class="header-content">
        <h2><i class="fa fa-home"></i>Sasaran {{$target->name}}</h2>
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
                                <td>: <a href="{{route('renstra.program.index', [$activity->program->plan->id])}}">{{$activity->program->plan->period->year_begin}} - {{$activity->program->plan->period->year_end}}</a></td>
                            </tr>
                            <tr>
                                <th>Program</th>
                                <td>: <a href="{{route('renstra.program.kegiatan.index', [
                                        $activity->program->plan->id,
                                        $activity->program->id
                                    ])}}">{{$activity->program->name}}</a></td>
                            </tr>
                            <tr>
                                <th>Kegiatan</th>
                                <td>: <a href="{{route('renstra.program.kegiatan.sasaran.index', [
                                        $activity->program->plan->id,
                                        $activity->program->id,
                                        $activity->id
                                    ])}}">{{$activity->name}}</a></td>
                            </tr>
                            <tr>
                                <th>Sasaran</th>
                                <td>: <strong>{{$target->name}}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            @if(!Gate::check('read-only'))
            <div class="col-md-4">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Indikator sasaran</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        {!! Form::open([
                            'route'    => ['renstra.program.kegiatan.sasaran.indikator.store',
                                $activity->program->plan->id,
                                $activity->program->id,
                                $activity->id,
                                $target->id
                            ],
                            'class'     => 'app-form',
                            'id'        => 'form-' . $viewId,
                            'data-table' => $viewId . '-datatables'
                        ]) !!}

                        <div class="alert-wrapper"></div>

                        <div class="form-group">
                            <label for="name">Nama indikator</label>
                            <textarea name="name" id="name" placeholder="Nama sasaran program" class="form-control autosize"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="name">Satuan</label>
                            <input type="text" name="unit" id="unit" placeholder="Satuan" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="name">Lokasi</label>
                            <input type="text" name="location" id="location" placeholder="Lokasi" class="form-control " />
                        </div>

                        <button type="submit" class="btn btn-info btn-block btn-lg save">
                            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save
                        </button>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            @endif

            <div class="@can('read-only') col-md-12 @else col-md-8 @endcan">

                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Daftar indikator sasaran</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

                        <table class="table table-striped table-bordered" id="{{$viewId}}-datatables">
                            <thead>
                            <tr>
                                <th>Indikator</th>
                                <th>Satuan</th>
                                <th>Lokasi</th>

                                @if(!Gate::check('read-only'))
                                <th>Action</th>
                                @endif
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

            var table = $('#{{$viewId}}-datatables').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{route('renstra.program.kegiatan.sasaran.indikator.data')}}",
                    data: function(d) {
                        d.plan = {{$activity->program->plan->id}};
                        d.program = {{$activity->program->id}};
                        d.activity = {{$activity->id}};
                        d.target = {{$target->id}};
                    }
                },
                columns: [
                    {data:'name',name:'name'},
                    {data:'unit',name:'unit'},
                    {data:'location',name:'location'},

                    @if(!Gate::check('read-only'))
                    {data:'action',name:'action', orderable:false, searchable:false}
                    @endif
                ]
            });

            autosize($('textarea'));

        });
    </script>
@stop