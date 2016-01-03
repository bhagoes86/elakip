@extends('private.layout')

@section('content')
    <div class="header-content">
        <h2><i class="fa fa-home"></i>Capaian Kinerja Kegiatan Fisik</h2>
    </div>

    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-md-12">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Filter Indicator</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        <form action="{{route('capaian.renstra.fisik.indicator')}}" method="get">
                            <div class="form-group">
                                <label for="year">Rencana Strategis</label>
                                {!! Form::select('plan', $plans, $id['plan'], [
                                    'placeholder' => '-Select Renstra-',
                                    'class' => 'form-control',
                                    'id'=>'plan']) !!}
                            </div>
                            <div class="form-group">
                                <label for="year">Tahun</label>
                                {!! Form::select('year', $years, $id['year'], [
                                    'placeholder' => '-Select Year-',
                                    'class' => 'form-control',
                                    'id'=>'year']) !!}
                            </div>
                            <div class="form-group">
                                <label for="agreement">Perjanjian kinerja</label>
                                {!! Form::select('agreement', $agreements, $id['agreement'], [
                                    'placeholder' => '-Select Agreement-',
                                    'class' => 'form-control',
                                    'id'=>'agreement']) !!}
                            </div>
                            <div class="form-group">
                                <label for="program">Program</label>
                                {!! Form::select('program', $programs, $id['program'], [
                                   'placeholder' => '-Select Program-',
                                   'class' => 'form-control',
                                   'id'=>'program']) !!}

                            </div>
                            <div class="form-group">
                                <label for="activity">Kegiatan</label>
                                {!! Form::select('activity', $activities, $id['activity'], [
                                    'placeholder' => '-Select Activity-',
                                    'class' => 'form-control',
                                    'id'=>'activity']) !!}
                            </div>
                            <div class="form-group">
                                <label for="target">Sasaran</label>
                                {!! Form::select('target', $targets, $id['target'], [
                                    'placeholder' => '-Select Target-',
                                    'class' => 'form-control',
                                    'id'=>'target']) !!}
                            </div>

                            <button type="submit" class="btn btn-primary"> Load </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Detail indicator</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        <div class="table-responsive">
                        <table class="table table-condensed table-bordered table-striped">
                            <thead>
                            <tr>
                                <th rowspan="2">Indikator</th>
                                <th rowspan="2" class="text-center">Satuan</th>

                                <th colspan="{{count($indicators['header']['years'])+1}}" class="text-center">Target</th>
                                <th colspan="{{count($indicators['header']['years'])+1}}" class="text-center">Capaian</th>
                            </tr>
                            <tr>
                                @foreach($indicators['header']['years'] as $year)
                                    <th class="text-center">{{$year}}</th>
                                @endforeach
                                <th class="text-center"><b>Total</b></th>

                                @foreach($indicators['header']['years'] as $year)
                                    <th class="text-center">{{$year}}</th>
                                @endforeach
                                <th class="text-center"><b>Total</b></th>

                            </tr>

                            </thead>
                            <tbody>
                            @foreach($indicators['data'] as $indicator)
                                <tr>
                                    <td>
                                        <span>{{$indicator['name']}}</span>
                                        <button class="btn btn-xs btn-primary btn-chart"
                                                onclick="showEdit(this)"
                                                data-modal-id="{{$viewId}}"
                                                data-url="{{route('capaian.renstra.fisik.indicator.chart', $indicator['id'])}}"
                                                data-title="{{$indicator['name']}}">

                                            <i class="fa fa-bar-chart"></i>
                                        </button>
                                    </td>
                                    <td>{{$indicator['unit']}}</td>

                                    @foreach($indicator['goal']['years'] as $year => $value)
                                        <td>{{$year}}: {{$value}}</td>
                                    @endforeach
                                    <td>{{$indicator['goal']['total']}}</td>

                                    @foreach($indicator['achievement']['years'] as $year => $value)
                                        <td>{{$year}}: {{$value}}</td>
                                    @endforeach
                                    <td>{{$indicator['achievement']['total']}}</td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
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
    <script src="{{asset('lib/highcharts/highcharts.js')}}"></script>

@stop

@section('styles')
    <link rel="stylesheet" href="{{asset('lib/datatables/media/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('lib/select2/dist/css/select2.min.css')}}"/>
@stop

@section('script')
    <script type="text/javascript">
        $(function() {
            "use strict";

            var $yearFilter = $('#year-filter');


            $yearFilter.change(function () {
                var $this = $(this),
                        value = $this.val();

                table.ajax.reload();
            });

            $('#year').on('change', function () {
                var $this = $(this);

                $('#agreement').html('');
                $('#program').html('');
                $('#activity').html('');
                $('#target').html('');

                $.get('{{route('pk.select2')}}', {
                    year: $this.find(':selected').val()
                }, function (response) {
                    $('#agreement').html(response);
                })
            });

            $('#agreement').on('change', function () {
                var $this = $(this);

                $('#program').html('');
                $('#activity').html('');
                $('#target').html('');

                $.get('{{route('program.select2')}}', {
                    agreement: $this.find(':selected').val()
                }, function (response) {
                    $('#program').html(response);
                })
            });

            $('#program').on('change', function () {
                var $this = $(this);

                $('#activity').html('');
                $('#target').html('');

                $.get('{{route('kegiatan.select2')}}', {
                    program: $this.find(':selected').val()
                }, function (response) {
                    $('#activity').html(response);
                })
            });

            $('#activity').on('change', function () {
                var $this = $(this);

                $('#target').html('');
                $.get('{{route('sasaran.select2')}}', {
                    activity: $this.find(':selected').val()
                }, function (response) {
                    $('#target').html(response);
                })
            });



        });
    </script>
@stop