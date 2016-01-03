@extends('private.layout')

@section('content')
    <div class="header-content">
        <h2><i class="fa fa-home"></i>Evaluasi Kinerja</h2>
    </div>

    <div class="body-content animated fadeIn">

        <div class="row mbot-15">
            <div class="col-md-12">
                <a href="{{route('kegiatan.evaluasi')}}?year={{$agreement->year}}&agreement={{$agreement->id}}&program={{$activity->program->id}}" class="btn btn-danger">
                    <i class="fa fa-arrow-left"></i> Back
                </a>

                @if(!Gate::check('read-only'))
                <a href="{{route('kegiatan.evaluasi.create', [$activity->id])}}?agreement={{$agreement->id}}" class="btn btn-success">
                    <i class="fa fa-plus"></i> New
                </a>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel rounded shadow">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Detail evaluasi kinerja</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped table-condensed">
                            {{--<tr>
                                <th>Id</th>
                                <td>: <a href="{{route('perjanjian-kerja.program.index', $agreement->id)}}">{{$agreement->id}}</a></td>
                            </tr>--}}
                            <tr>
                                <th>Tahun</th>
                                <td>: {{$agreement->year}}</td>
                            </tr>
                            <tr>
                                <th>Pihak pertama</th>
                                <td>: {{$agreement->firstPosition->user->name}}</td>
                            </tr>
                            <tr>
                                <th>Pihak kedua</th>
                                <td>: {{$agreement->secondPosition->user->name}}</td>
                            </tr>
                            <tr>
                                <th>Program</th>
                                <td>: {{$activity->program->name}}</td>
                            </tr>
                            <tr>
                                <th>Kegiatan</th>
                                <td>: <strong>{{$activity->name}}</strong></td>
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
                            <h3 class="panel-title">Evaluasi</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped table-bordered" id="{{$viewId}}-datatables">
                            <thead>
                            <tr>
                                <th>Kendala</th>
                                <th>Solusi</th>

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
    <script>
        $(function(){
            var table = $('#{{$viewId}}-datatables').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{route('evaluasi.data')}}",
                    data: function(d) {
                        d.activity = {{$activity->id}};
                        d.agreement = {{$agreement->id}};
                    }
                },
                columns: [
                    {data:'issue',name:'issue'},
                    {data:'solutions',name:'solutions'},

                    @if(!Gate::check('read-only'))
                    {data:'action',name:'action',orderable:false,searchable:false}
                    @endif
                ]
            });
        });
    </script>
@stop