@extends('private.layout')

@section('content')
    <div class="header-content">
        <h2><i class="fa fa-home"></i>Capaian Kinerja Anggaran Per Periode</h2>
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
                        <form action="{{route('capaian.renstra.anggaran.kegiatan')}}" method="get">
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

                           {{-- <div class="form-group">
                                <label for="program">Program</label>
                                {!! Form::select('program', $programs, $id['program'], ['class' => 'form-control','id'=> 'program','placeholder' => '-Pilih Program-']) !!}

                            </div>--}}

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
                            <h3 class="panel-title">Detil Kegiatan</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

                        <div class="table-responsive">
                            <table class="table table-condensed table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th rowspan="2">Kegiatan</th>

                                    <th colspan="{{count($activities['header']['years'])}}" class="text-center">Anggaran</th>
                                    <th colspan="{{count($activities['header']['years'])}}" class="text-center">Realisasi</th>
                                </tr>
                                <tr>
                                    @foreach($activities['header']['years'] as $year)
                                        <th class="text-center">{{$year}}</th>
                                    @endforeach
                                    {{--<th class="text-center"><b>Total</b></th>--}}

                                    @foreach($activities['header']['years'] as $year)
                                        <th class="text-center">{{$year}}</th>
                                    @endforeach
                                    {{--<th class="text-center"><b>Total</b></th>--}}

                                </tr>

                                </thead>
                                <tbody>
                                @foreach($activities['data'] as $activity)
                                    <tr>
                                        <td>
                                            <span>{{$activity['name']}}</span>
                                            <button class="btn btn-xs btn-primary btn-chart"
                                                    onclick="showEdit(this)"
                                                    data-modal-id="{{$viewId}}"
                                                    data-url="{{route('capaian.renstra.anggaran.kegiatan.chart', $activity['id'])}}"
                                                    data-title="{{$activity['name']}}">

                                                <i class="fa fa-bar-chart"></i>
                                            </button>
                                        </td>

                                        @foreach($activity['budget']['pagu'] as $pagu)
                                            <td>{{money_format('%.2n', $pagu)}}</td>
                                        @endforeach
{{--                                        <td>{{$activity['goal']['total']}}</td>--}}

                                        @foreach($activity['budget']['real'] as $real)
                                            <td>{{money_format('%.2n', $real)}}</td>
                                        @endforeach
{{--                                        <td>{{$activity['achievement']['total']}}</td>--}}

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

           /* $('#unit').on('change', function () {
                var $this = $(this);

                $('#program').html('<option>..Loading..</option>');
                $('#activity').html('');

                $.get('{{url('renstra/program/select2')}}', {
                    plan: $('#plan').val()
                }, function (response) {
                    $('#program').html(response);
                })
            });*/
        });
    </script>
@stop