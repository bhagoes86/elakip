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
                                {!! Form::select('plan', $plans, null, [
                                    'placeholder' => '-Select Renstra-',
                                    'class' => 'form-control',
                                    'id'=>'plan']) !!}
                            </div>
                            <div class="form-group">
                                <label for="year">Tahun</label>
                                {!! Form::select('year', $years, null, [
                                    'placeholder' => '-Select Year-',
                                    'class' => 'form-control',
                                    'id'=>'year']) !!}
                            </div>
                            <div class="form-group">
                                <label for="agreement">Perjanjian kinerja</label>
                                <select id="agreement" name="agreement" class="form-control"></select>
                            </div>
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
                        <div class="item">
                            <div class="mbot-15">
                                <span>Kegiatan Satu</span>
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
                                            <th colspan="{{($period->year_end - $period->year_begin)+2}}" class="text-center">Pagu</th>
                                            <th colspan="{{($period->year_end - $period->year_begin)+2}}" class="text-center">Realisasi</th>
                                        </tr>
                                        <tr>
                                            @for($year = $period->year_begin; $year <= $period->year_end; $year++)
                                                <th class="text-center">{{$year}}</th>
                                            @endfor
                                                <th class="text-center"><strong>Total</strong></th>

                                            @for($year = $period->year_begin; $year <= $period->year_end; $year++)
                                                <th class="text-center">{{$year}}</th>
                                            @endfor
                                                <th class="text-center"><strong>Total</strong></th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>Rp.2.000.000.000.000</td>
                                            <td>Rp.2.000.000.000.000</td>
                                            <td>Rp.2.000.000.000.000</td>
                                            <td>Rp.2.000.000.000.000</td>
                                            <td>Rp.2.000.000.000.000</td>
                                            <td>Rp.2.000.000.000.000</td>
                                            <td>Rp.2.000.000.000.000</td>
                                            <td>Rp.2.000.000.000.000</td>
                                            <td>Rp.2.000.000.000.000</td>
                                            <td>Rp.2.000.000.000.000</td>
                                            <td>Rp.2.000.000.000.000</td>
                                            <td>Rp.2.000.000.000.000</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
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





        });
    </script>
@stop