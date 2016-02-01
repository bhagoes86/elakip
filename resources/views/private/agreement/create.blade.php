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
                        @if (count($errors) > 0)
                        <div class="alert-wrapper">
                            <div class="alert alert-danger alert-dismissible fade in" role="alert" data-dismiss="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>

                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                        @endif


                        {!! Form::open([
                            'route' => 'pk.store'
                        ]) !!}

                        <div class="form-group @if($errors->has('year')) has-error @endif">
                            <label for="name">Tahun</label>
                            {!! Form::select('year', $years, null, ['class'=>"form-control", 'placeholder'=>"Tahun", 'id'=>"year"]) !!}
                        </div>

                        <div class="form-group @if($errors->has('first_user_id')) has-error @endif">
                            <label for="first_user">Pihak pertama</label>
                            <select name="first_user_id" id="first_user" class="form-control"></select>
                        </div>

                        <div class="form-group @if($errors->has('second_user_id')) has-error @endif">
                            <label for="second_user">Pihak kedua</label>
                            <select name="second_user_id" id="second_user" class="form-control"></select>
                        </div>

                        <div class="form-group @if($errors->has('date_agreement')) has-error @endif">
                            <label for="date_agreement">Tanggal perjanjian</label>
                            {!! Form::text('date_agreement', null, ['class'=>"form-control", 'id'=>"date_agreement", 'placeholder'=>"Tanggal perjanjian"]) !!}
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

        function getFirstUserInYear()
        {
            $.get('{{route('user.first.year')}}', {
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
                getFirstUserInYear();
            });

            $('#date_agreement').datepicker({
                format: 'yyyy-mm-dd',
                todayBtn: 'linked'
            });

            getUserInYear();
            getFirstUserInYear();

        });
    </script>
@stop