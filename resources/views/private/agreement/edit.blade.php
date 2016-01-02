@extends('private.layout')

@section('content')
    <div class="header-content">
        <h2><i class="fa fa-home"></i>Perjanjian Kerja</h2>
        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">You are here:</span>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="#">Pengaturan</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    Year
                </li>
            </ol>
        </div>
    </div>

    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-md-12">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Edit perjanjian kinerja</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        {!! Form::model($agreement, [
                            'route' => ['pk.update', $agreement->id],
                            'method' => 'PUT'
                        ]) !!}

                        {{--<input type="hidden" name=
                        "unit" id="unit_id" value="{{$agreement->unit_id}}"/>--}}
                        <div class="form-group">
                            <label for="plan_id">Renstra</label>
                            {!! Form::select('plan_id', $plans, null, ['class'=>"form-control", 'placeholder'=>"Renstr", 'id'=>"plan_id"]) !!}
                        </div>
                        <div class="form-group">
                            <label for="year">Tahun</label>
                            {!! Form::select('year', $years, null, ['class'=>"form-control", 'placeholder'=>"Tahun", 'id'=>"year"]) !!}
                        </div>

                        <div class="form-group">
                            <label for="first_user">Pihak pertama</label>
                            {!! Form::select('first_position_id', $firstPositions, null, ['class'=>"form-control", 'id'=>"first_user"]) !!}
                        </div>

                       {{-- <div class="form-group">
                            <label for="second_user">Pihak kedua</label>
                            <select name="second_user_id" id="second_user" class="form-control">
                                @foreach($secondPositions as $key => $val)
                                    <option value="{{$key}}" data-unit-id="{{$val['unit_id']}}"
                                    @if($key == $agreement->second_user_id)
                                            selected
                                            @endif >{{$val['text']}}</option>
                                @endforeach
                            </select>

                        </div>--}}

                        <div class="form-group">
                            <label for="first_user">Pihak kedua</label>
                            {!! Form::select('second_position_id', $secondPositions, null, ['class'=>"form-control", 'id'=>"second_user"]) !!}
                        </div>

                        <div class="form-group">
                            <label for="date_agreement">Tanggal perjanjian</label>
                            {!! Form::text('date', null, ['class' => 'form-control', 'id' => 'date']) !!}
                        </div>

                        <button type="submit" class="btn btn-info btn-lg save">
                            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update
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

          /*  $('#second_user').change(function () {
                var unitId = $(this).find(':selected').data('unit-id');
                $('#unit_id').val(unitId);
            });*/

            $('#date').datepicker({
                format: 'yyyy-mm-dd',
                todayBtn: 'linked'
            });
            /*
             getUserInYear();
             getDitjenInYear();*/

        });
    </script>
@stop