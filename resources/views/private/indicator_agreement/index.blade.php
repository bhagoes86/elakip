@extends('private.layout')

@section('content')

    <div class="header-content">
        <h2><i class="fa fa-home"></i>Indikator</h2>
    </div>

    <div class="body-content animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="panel rounded shadow">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Detail perjanjian kinerja</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped table-condensed">
                            <tr>
                                <th>Id</th>
                                <td>: <a href="{{route('pk.program.index', $agreement->id)}}">{{$agreement->id}}</a></td>
                            </tr>
                            <tr>
                                <th>Tahun</th>
                                <td>: {{$agreement->year}}</td>
                            </tr>
                            <tr>
                                <th>Pihak pertama</th>
                                <td>: {{$agreement->firstPosition->user->name}} ({{$agreement->firstPosition->position}})</td>
                            </tr>
                            <tr>
                                <th>Pihak kedua</th>
                                <td>: {{$agreement->secondPosition->user->name}} ({{$agreement->secondPosition->position}})</td>
                            </tr>
                            <tr>
                                <th>Program</th>
                                <td>: <a href="{{route('pk.program.kegiatan.index', [
                                    $agreement->id,
                                    $activity->program->id
                                ])}}">{{$activity->program->name}}</a></td>
                            </tr>
                            <tr>
                                <th>Kegiatan</th>
                                <td>: <a href="{{route('pk.program.kegiatan.sasaran.index', [
                                     $agreement->id,
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

            <div class="col-md-12">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Daftar indikator</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

                        <table class="table table-striped table-bordered" id="{{$viewId}}-datatables">
                            <thead>
                            <tr>
                                <th>Indikator</th>
                                <th>Target</th>

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
                    url: "{{route('pk.program.kegiatan.sasaran.indikator.data')}}",
                    data: function(d) {
                        d.agreement = {{$id['agreement']}};
                        d.program = {{$id['program']}};
                        d.activity = {{$id['activity']}};
                        d.target = {{$id['target']}};
                    }
                },
                columns: [
                    {data:'name',name:'name'},
                    {data:'target',name:'target'},

                    @if(!Gate::check('read-only'))
                    {data:'action',name:'action'}
                    @endif
                ]
            });
        });
    </script>
@stop