@extends('private.layout')

@section('content')
    <div class="header-content">
        <h2><i class="fa fa-home"></i>Capaian Kinerja Sasaran Program/Kegiatan</h2>
    </div>

    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-md-12">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Filter Indikator</h3>
                        </div>
                        <div class="pull-right">
                            <button class="btn btn-sm"
                                    data-action="collapse"
                                    data-container="body"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    data-title="Collapse"
                                    data-original-title=""
                                    title=""><i class="fa fa-angle-down"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body" style="display: none">
                        <form action="{{route('capaian.renstra.fisik.indicator')}}" method="get">
                            {!! Form::hidden('plan', $id['plan'], ['id' => 'plan']) !!}

                            {{--<div class="form-group">
                                <label for="year">Rencana Strategis</label>
                                {!! Form::select('plan', $plans, $id['plan'], [
                                    'placeholder' => '-Select Renstra-',
                                    'class' => 'form-control',
                                    'id'=>'plan']) !!}
                            </div>--}}

                            <div class="form-group">
                                <label for="unit">Unit</label>
                                {!! Form::select('unit', $units, $id['unit'], ['class' => 'form-control','id'=> 'unit','placeholder' => '-Pilih Unit-']) !!}
                            </div>

                            <div class="form-group">
                                <label for="program">Program</label>
                                {!! Form::select('program', $programs, $id['program'], ['class' => 'form-control','id'=> 'program','placeholder' => '-Pilih Program-']) !!}


                            </div>
                            <div class="form-group">
                                <label for="activity">Kegiatan</label>
                                {!! Form::select('activity', $activities, $id['activity'], ['class' => 'form-control','id'=> 'activity','placeholder' => '-Pilih Kegiatan-']) !!}


                            </div>
                            <div class="form-group">
                                <label for="target">Sasaran</label>
                                {!! Form::select('target', $targets, $id['target'], ['class' => 'form-control','id'=> 'target','placeholder' => '-Pilih Target-']) !!}

                            </div>

                            <button type="submit" class="btn btn-primary"> Load </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Grafik Per Tahun</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        {{--<div class="btn-group">--}}
                            @foreach($indicators['header']['years'] as $year)
                                <button type="button" class="btn btn-danger year-chart" data-year="{{$year}}" data-title="{{$year}}">
                                    <i class="fa fa-bar-chart"></i> {{$year}}
                                </button>
                            @endforeach
                        {{--</div>--}}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Tabel Per Tahun</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        {{--<div class="btn-group">--}}
                            @foreach($indicators['header']['years'] as $year)
                                <button type="button" class="btn btn-success year-table" data-year="{{$year}}" data-title="{{$year}}">
                                    <i class="fa fa-table"></i> {{$year}}
                                </button>
                            @endforeach
                        {{--</div>--}}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Tabel Triwulan Per Tahun</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        {{--<div class="btn-group">--}}
                            @foreach($indicators['header']['years'] as $year)
                                <button type="button" class="btn btn-success quarter-table" data-year="{{$year}}" data-title="{{$year}}">
                                    <i class="fa fa-table"></i> {{$year}}
                                </button>
                            @endforeach
                        {{--</div>--}}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Detil indikator</h3>
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
    {{--                                                data-title="{{$indicator['name']}}">--}}
                                                    data-title="Grafik Indikator {{$indicator['name']}} 2015-2019">


                                                <i class="fa fa-bar-chart"></i>
                                            </button>
                                        </td>
                                        <td>{{$indicator['unit']}}</td>

                                        @foreach($indicator['goal']['years'] as $year => $value)
                                            <td>{{$value}}</td>
                                        @endforeach
                                        <td>{{$indicator['goal']['total']}}</td>

                                        @foreach($indicator['achievement']['years'] as $year => $value)
                                            <td>{{$value}}</td>
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
    @include('private._partials.modal_large')
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

            $('#unit').on('change', function () {
                var $this = $(this);

                $('#program').html('<option>..Loading..</option>');
                $('#activity').html('');
                $('#target').html('');

                $.get('{{url('renstra/program/select2')}}', {
                    plan: $('#plan').val()
                }, function (response) {
                    $('#program').html(response);
                })
            });

            $('#program').on('change', function () {
                var $this = $(this);

                $('#activity').html('<option>..Loading..</option>');
                $('#target').html('');

                $.get('{{url('renstra/activity/select2')}}', {
                    program: $this.find(':selected').val(),
                    unit: $('#unit').find(':selected').val()
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

            $('.year-chart').click(function(){
                var $this = $(this);
                var modalId = '{{$viewId}}-lg';
                var title = $this.data('title');
                var year = $this.data('year');

                console.log($this);

                $('#' + modalId + '-label').html(title);
                $.get('{{url('capaian/renstra/fisik/target') .'/'. $id['target']}}/year/'+year+'/chart', function(r) {
                    return $('#' + modalId + ' .modal-body').html(r);
                });
                return $('#' + modalId).modal();
            });

            $('.year-table').click(function(){
                var $this = $(this);
                var modalId = '{{$viewId}}-lg';
                var title = $this.data('title');
                var year = $this.data('year');

                console.log($this);

                $('#' + modalId + '-label').html(title);
                $.get('{{url('capaian/renstra/fisik/target') .'/'. $id['target']}}/year/'+year+'/table', function(r) {
                    return $('#' + modalId + ' .modal-body').html(r);
                });
                return $('#' + modalId).modal();
            });

            $('.quarter-table').click(function(){
                var $this = $(this);
                var modalId = '{{$viewId}}-lg';
                var title = $this.data('title');
                var year = $this.data('year');

                console.log($this);

                $('#' + modalId + '-label').html(title);
                $('#' + modalId + ' .modal-body').html('');
                $.get('{{url('capaian/renstra/fisik/target') .'/'. $id['target']}}/year/'+year+'/quarter', function(r) {
                    return $('#' + modalId + ' .modal-body').html(r);
                });
                return $('#' + modalId).modal();
            });

        });
    </script>
@stop