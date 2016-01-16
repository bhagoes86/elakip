@extends('private.layout')

@section('content')
    <div class="header-content">
        <h2><i class="fa fa-home"></i>Capaian Kinerja Anggaran Per Tahun</h2>

    </div>

    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-md-12">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Filter kegiatan</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        <form action="{{route('capaian.anggaran.kegiatan')}}" method="get">
                            {!! Form::hidden('plan', $plan->id, ['id' => 'plan']) !!}
                           {{-- <div class="form-group">
                                <label for="year">Periode</label>
                                {!! Form::select('plan', $plans, null, [
                                    'placeholder' => '-Pilih Periode-',
                                    'class' => 'form-control',
                                    'id'=>'plan']) !!}
                            </div>--}}
                            <div class="form-group">
                                <label for="year">Tahun</label>
                                {!! Form::select('year', $years, null, [
                                    'placeholder' => '-Select Year-',
                                    'class' => 'form-control',
                                    'id'=>'year']) !!}
                            </div>
                            {{--<div class="form-group">
                                <label for="agreement">Perjanjian kinerja</label>
                                <select id="agreement" name="agreement" class="form-control"></select>
                            </div>--}}
                            <div class="form-group">
                                <label for="program">Program</label>
                                <select id="program" name="program" class="form-control"></select>

                            </div>

                            <button type="submit" class="btn btn-primary"> Load </button>
                        </form>
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
    <script src="{{asset('lib/select2/dist/js/select2.min.js')}}"></script>
@stop

@section('styles')
    <link rel="stylesheet" href="{{asset('lib/datatables/media/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('lib/select2/dist/css/select2.min.css')}}"/>
@stop

@section('script')
    <script type="text/javascript">
        $(function() {
            "use strict";

            $('#year').on('change', function () {
                var $this = $(this);

                $('#agreement').html('');
                $('#program').html('');
                $('#activity').html('');

                /*$.get('{{route('pk.select2')}}', {
                    year: $this.find(':selected').val()
                }, function (response) {
                    $('#agreement').html(response);
                })*/

                $.get('{{route('program.select2')}}', {
                }, function (response) {
                    $('#program').html(response);
                })
            });

            /*$('#agreement').on('change', function () {
                var $this = $(this);

                $('#program').html('');
                $('#activity').html('');
                $('#target').html('');

                $.get('{{route('program.select2')}}', {
                    agreement: $this.find(':selected').val()
                }, function (response) {
                    $('#program').html(response);
                })
            });*/

           /* $('#program').on('change', function () {
                var $this = $(this);

                $('#activity').html('');
                $('#target').html('');

                $.get('{{route('kegiatan.select2')}}', {
                    program: $this.find(':selected').val()
                }, function (response) {
                    $('#activity').html(response);
                })
            });*/



        });
    </script>
@stop