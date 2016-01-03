@extends('private.layout')

@section('content')
    <div class="header-content">
        <h2><i class="fa fa-home"></i>Perjanjian Kinerja</h2>
    </div>

    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-md-12">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Buat perjanjian kinerja</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        {!! Form::open([
                            'route' => 'pk.store'
                        ]) !!}

                       {{-- <input type="hidden" name="unit" id="unit_id"/>--}}

                        <div class="form-group">
                            <label for="plan_id">Renstra</label>
                            {!! Form::select('plan_id', $plans, null, ['class'=>"form-control", 'placeholder'=>"Renstr", 'id'=>"plan_id"]) !!}
                        </div>

                        <div class="form-group">
                            <label for="name">Tahun</label>
                            {!! Form::select('year', $years, null, ['class'=>"form-control", 'placeholder'=>"Tahun", 'id'=>"year"]) !!}
                        </div>

                        <div class="form-group">
                            <label for="first_user">Pihak pertama</label>
                            <select name="first_user_id" id="first_user" class="form-control"></select>
                        </div>

                        <div class="form-group">
                            <label for="second_user">Pihak kedua</label>
                            <select name="second_user_id" id="second_user" class="form-control"></select>
                        </div>

                        <div class="form-group">
                            <label for="date_agreement">Tanggal perjanjian</label>
                            <input type="text" class="form-control" id="date_agreement" name="date_agreement" placeholder="Tanggal perjanjian"/>
                        </div>

                        <button type="submit" class="btn btn-info btn-lg save">
                            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save
                        </button>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{asset('lib/bootstrap-datepicker-vitalets/js/bootstrap-datepicker.js')}}"></script>
@stop

@section('styles')
    <link rel="stylesheet" href="{{asset('lib/bootstrap-datepicker-vitalets/css/datepicker.css')}}"/>
@stop

@section('script')
    <script type="text/javascript">

        function getUserInYear()
        {
            $.get('{{route('user.year')}}', {
                year: $('#year').val()
            }, function(r) {
                $('#second_user').html(r);
            });
        }

        function getDitjenInYear()
        {
            $.get('{{route('user.ditjen.year')}}', {
                year: $('#year').val()
            }, function(r) {
                $('#first_user').html(r);
            });
        }


        $(function() {
            $('#year').change(function() {
                var loadingHtml = '<option> ... Loading ... </option>';
                $('#first_user').html(loadingHtml);
                $('#second_user').html(loadingHtml);

                getUserInYear();
                getDitjenInYear();
            });

            $('#date_agreement').datepicker({
                format: 'yyyy-mm-dd',
                todayBtn: 'linked'
            });

            getUserInYear();
            getDitjenInYear();

        });
    </script>
@stop