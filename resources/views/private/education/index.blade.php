@extends('private.layout')

@section('content')

    <div class="header-content">
        <h2><i class="fa fa-home"></i> Tingkat Pendidikan</h2>
    </div>

    <div class="body-content animated fadeIn">

        <div class="row mbot-15">
            <div class="col-md-12">
                <a href="{{ route('sdm.index') }}" class="btn btn-danger">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>


        <div class="row">
            <div class="col-md-4">
                <div class="panel rounded shadow">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Tambah Pendidikan</h3>
                        </div>
                        <div class="clearfix"></div>

                    </div>
                    <div class="panel-body">

                        {!! Form::open([
                            'route' => ['sdm.education.store', $staff->id],
                            'class' => 'app-form',
                            'id'    => 'form-' . $viewId,
                            'data-table' => $viewId . '-datatables'

                        ]) !!}

                        <div class="form-group">
                            <label for="level">Jenjang</label>
                            {!! Form::select('level', $levels, null, ['class' => 'form-control', 'placeholder' => '- Pilih Satu -']) !!}
                        </div>

                        <div class="form-group">
                            <label for="institution">Institusi</label>
                            {!! Form::text('institution', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            <label for="major">Jurusan</label>
                            {!! Form::text('major', null, ['class' => 'form-control']) !!}
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
                            <h3 class="panel-title">Daftar Pendidikan {{ $staff->name }}</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

                        <table class="table table-striped table-bordered" id="{{$viewId}}-datatables">
                            <thead>
                            <tr>
                                <th>Jenjang</th>
                                <th>Institusi</th>
                                <th>Jurusan</th>
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
                    url: "{{route('sdm.education.data')}}",
                    data: function(d) {
                        d.staff = {{$staff->id}};

                    }
                },
                columns: [
                    {data:'level',name:'level'},
                    {data:'institution',name:'institution'},
                    {data:'major',name:'major'},
                    {data:'action',name:'action',orderable:false,searchable:false}
                ]
            });
        });
    </script>
@stop