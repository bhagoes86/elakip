@extends('private.layout')

@section('content')

    <div class="header-content">
        <h2><i class="fa fa-home"></i>SDM</h2>
    </div>

    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-md-4">
                <div class="panel rounded shadow">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Tambah Staff</h3>
                        </div>
                        <div class="clearfix"></div>

                    </div>
                    <div class="panel-body">

                        {!! Form::open([
                            'route' => 'sdm.store',
                            'class' => 'app-form',
                            'id'    => 'form-' . $viewId,
                            'data-table' => $viewId . '-datatables'

                        ]) !!}

                        <div class="alert-wrapper"></div>

                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" id="name" class="form-control" name="name"/>
                        </div>

                        <div class="form-group">
                            <label for="organization_id">Organization</label>
                            {!! Form::select('organization_id', $organizations, null, ['class' => 'form-control', 'id' => 'organization_id', 'placeholder' => '- organisasi -']) !!}
                        </div>

                        <div class="form-group">
                            <label for="position">Posisi</label>
                            <input type="text" id="position" class="form-control" name="position"/>
                        </div>

                        <div class="form-group">
                            <label class="radio-inline">
                                <input type="radio" name="status" id="status-pns" value="pns" checked> PNS
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="status" id="status-non-pns" value="non-pns"> Non PNS
                            </label>
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
                            <h3 class="panel-title">Daftar Staff</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

                        <table class="table table-striped table-bordered" id="{{$viewId}}-datatables">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Organisasi</th>
                                <th>Status</th>
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
                    url: "{{route('sdm.data')}}"
                },
                columns: [
                    {data:'name',name:'name'},
                    {data:'organization.name',name:'organization.name'},
                    {data:'status',name:'status'},
                    {data:'position',name:'position'},
                    {data:'action',name:'action',orderable:false,searchable:false}
                ]
            });
        });
    </script>
@stop