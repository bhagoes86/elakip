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
                        <form action="{{route('capaian.renstra.anggaran.kegiatan')}}" method="get">
                            <div class="form-group">
                                <label for="year">Rencana Strategis</label>
                                {!! Form::select('plan', $plans, $id['plan'], [
                                    'placeholder' => '-Select Renstra-',
                                    'class' => 'form-control',
                                    'id'=>'plan']) !!}
                            </div>

                            <div class="form-group">
                                <label for="unit">Unit</label>
                                {!! Form::select('unit', $units, $id['unit'], ['class' => 'form-control','id'=> 'unit','placeholder' => '-Pilih Unit-']) !!}
                            </div>

                            <div class="form-group">
                                <label for="program">Program</label>
                                {!! Form::select('program', $programs, $id['program'], ['class' => 'form-control','id'=> 'program','placeholder' => '-Pilih Program-']) !!}

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
                            <h3 class="panel-title">Kegiatan</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        @foreach($activities['data'] as $activity)
                        <div class="row mbot-15 item">
                            <div class="col-md-12">
                            <div class="mbot-15">
                                <span><strong>{{$activity['name']}}</strong></span>
                                <button class="btn btn-xs btn-primary btn-chart"
                                        onclick="showEdit(this)"
                                        data-modal-id="{{$viewId}}"
                                        data-url="{{route('capaian.renstra.fisik.indicator.chart', 1)}}"
                                        data-title="xx">

                                    <i class="fa fa-bar-chart"></i>
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-condensed table-bordered table-striped">

                                    <thead>
                                        <tr>
                                            <th colspan="{{count($activities['header']['years'])}}" class="text-center">Pagu</th>
                                            <th colspan="{{count($activities['header']['years'])}}" class="text-center">Realisasi</th>
                                        </tr>
                                        <tr>
                                            @foreach($activities['header']['years'] as $year)
                                                <th class="text-center">{{$year}}</th>
                                            @endforeach
                                           {{-- <th class="text-center"><b>Total</b></th>
--}}
                                            @foreach($activities['header']['years'] as $year)
                                                <th class="text-center">{{$year}}</th>
                                            @endforeach
                                            {{--<th class="text-center"><b>Total</b></th>--}}

                                        </tr>
                                    </thead>


                                    <tbody>
                                        <tr>
                                        @foreach($activity['budget']['pagu'] as $pagu)
                                            <td>{{$pagu}}</td>
                                        @endforeach
                                        @foreach($activity['budget']['real'] as $real)
                                            <td>{{$real}}</td>
                                        @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                        @endforeach
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

            $('#plan').on('change', function () {
                var $this = $(this);

                $('#program').html('<option>..Loading..</option>');
                $('#activity').html('');

                $.get('{{url('renstra/program/select2')}}', {
                    plan: $('#plan').find(':selected').val()
                }, function (response) {
                    $('#program').html(response);
                })
            });
        });
    </script>
@stop