@extends('private.layout')

@section('content')

    <div class="header-content">
        <h2><i class="fa fa-home"></i>Program PK</h2>
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
                        <div class="row">

                            <div class="@can('read-only') col-md-12 @else col-md-8 @endcan">
                                <table class="table table-striped table-condensed">
                                    <tr>
                                        <th>Id</th>
                                        <td>: <a href="#">{{$agreement->id}}</a></td>
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
                                </table>

                                <h3>Dokumen</h3>
                                @if(count($agreement->media) > 0)
                                    <ul id="dokumen-pk">

                                        @foreach($agreement->media as $media)
                                            <li><a target="_blank" href="{{url('/') . '/' . $media->location}}">{{$media->original_name}}</a></li>
                                        @endforeach
                                    </ul>
                                @else
                                    @can('read-only')
                                    <i>Tidak ada dokumen</i>
                                    @else
                                    <i>Tidak ada dokumen, silahkan klik tombol "Upload dokumen" untuk upload dokumen baru</i>
                                    @endcan
                                @endif
                            </div>

                            @if(!Gate::check('read-only'))
                            <div class="col-md-4">
                                <a href="{{route('pk.export', [$agreement->id])}}" class="btn btn-success" target="_blank">
                                    <i class="fa fa-file-excel-o"></i> Export
                                </a>
                                <button class="btn btn-primary" id="upload-scan">
                                    <i class="fa fa-file-text-o"></i> Upload dokumen
                                </button>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-md-12">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Daftar program</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

                        <table class="table table-striped table-bordered" id="{{$viewId}}-datatables">
                            <thead>
                            <tr>
                                <th>Title</th>
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
    <script src="{{asset('lib/dropzone/dist/dropzone.js')}}"></script>

@stop

@section('styles')
    <link rel="stylesheet" href="{{asset('lib/datatables/media/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('lib/dropzone/dist/dropzone.css')}}"/>

@stop

@section('script')
    <script type="text/javascript">
        $(function() {
            "use strict";

            var table = $('#{{$viewId}}-datatables').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{url('pk/program/data')}}",
                    data: function(d) {
                        d.agreement = {{$id['agreement']}}
                    }
                },
                columns: [
                    {data:'name',name:'name'}
                ]
            });

            $('#upload-scan').click(function(){
                var     modalId = '{{$viewId}}',
                        $modalId = $('#'+modalId);

                $modalId .modal();
                $('#'+modalId+' .modal-body').html('');
                $('.modal #'+modalId+'-label').html('Upload');

                $.get('{{route('pk.doc.create', [$agreement->id])}}', function (response) {
                    $('#'+modalId+' .modal-body').html(response);

                });
            });
        });
    </script>
@stop