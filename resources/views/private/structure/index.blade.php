@extends('private.layout')

@section('content')

    <div class="header-content">
        <h2><i class="fa fa-home"></i>Stuktur Organisasi</h2>
    </div>

    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-md-4">
                <div class="panel rounded shadow">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Buat organisasi</h3>
                        </div>
                        <div class="clearfix"></div>

                    </div>
                    <div class="panel-body">

                        {!! Form::open([
                            'route' => 'structure.store',

                            'id'    => 'form-' . $viewId,
                            'data-table' => $viewId . '-datatables'

                        ]) !!}

                        <div class="alert-wrapper"></div>

                        <div class="form-group">
                            <label for="parent_id">Parent</label>
                            {{--<input id="parent-tree"/>
                            <input type="hidden" id="parent_id" name="parent_id"/>--}}
                            {!! Form::select('parent_id', $organizations, null, ['class' => 'form-control', 'id' => 'parent_id', 'placeholder' => '-none-']) !!}
                        </div>
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" id="name" class="form-control" name="name"/>
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
                            <h3 class="panel-title">Daftar Organisasi</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

                        <table class="table table-striped table-bordered" id="{{$viewId}}-datatables">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Parent</th>
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
                    url: "{{route('structure.data')}}"
                },
                columns: [
                    {data:'name',name:'name'},
                    {data:'parent_name',name:'parent_name'},
                    {data:'action',name:'action',orderable:false,searchable:false}
                ]
            });

            $('#form-{{$viewId}}').submit(function(e){

                e.preventDefault();

                var $form   = $(this),
                        id      =  $form.attr('id'),
                        table   = $form.data('table'),
                        tableDt = $('#' + table).DataTable();

                $('#' + id + ' .save').addClass('disabled');

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: $form.serialize(),
                    success: function(r) {
                        if (table !== void 0)
                            tableDt.ajax.reload();

                        $form.find('input[type=text], input[type=password], input[type=number], input[type=email], textarea').val('');

                        $('#' + id + ' .save').removeClass('disabled');
                        $('.alert-wrapper > .alert').fadeOut();
                        $('.alert-wrapper').html('');
                        $('.form-group').removeClass('has-error');

                        var html = '<div class="alert alert-success alert-dismissible fade in" role="alert" data-dismiss="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>Success</div>';
                        $('#' + id + ' .alert-wrapper').html(html);
                        $(".alert.alert-success").fadeTo(2000, 500).slideUp(500, function() {
                            return $(".alert.alert-success").alert('close');
                        });

                        $('#parent_id').html('<option> ... Loading ...</option>');
                        $.get('{{route('structure.parent')}}', function(resp) {
                            $('#parent_id').html(resp);
                        });
                    },
                    error: function(r) {
                        var errors, html;
                        $('#' + id + ' .form-group').removeClass('has-error');
                        errors = '<ul>';
                        $.each(r.responseJSON, function(key, val) {
                            errors += '<li>' + val + '</li>';
                            return $('#' + id + ' #' + key).parent().addClass('has-error');
                        });
                        errors += '</ul>';

                        html = '<div class="alert alert-danger alert-dismissible fade in" role="alert" data-dismiss="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>' + errors + '</div>';
                        $('#' + id + ' .alert-wrapper').html(html);
                        $('#' + id + ' .save').removeClass('disabled');
                    }
                });
            });
        });
    </script>
@stop