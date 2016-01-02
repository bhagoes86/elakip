@extends('private.layout')

@section('content')

    <div class="header-content">
        <h2><i class="fa fa-home"></i>Sasaran</h2>
    </div>

    <div class="body-content animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Daftar sasaran</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

                        <table class="table table-striped table-bordered" id="{{$viewId}}-datatables">
                            <thead>
                            <tr>
                                <th>Name</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                    url: "{{route('pk.program.kegiatan.sasaran.data')}}",
                    data: function(d) {
                        d.agreement = {{$id['agreement']}};
                        d.program = {{$id['program']}};
                        d.activity = {{$id['activity']}};
                    }
                },
                columns: [
                    {data:'name',name:'name'}
                ]
            });
        });
    </script>
@stop