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
                            <h3 class="panel-title">Filter Indicator</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        <form action="{{route('capaian.renstra.fisik.indicator')}}" method="get">
                            {!! Form::hidden('plan', $plan->id, ['id' => 'plan']) !!}

                            <div class="form-group">
                                <label for="unit">Unit</label>
                                {!! Form::select('unit', $units, null, ['class' => 'form-control','id'=> 'unit','placeholder' => '-Pilih Unit-']) !!}
                            </div>

                            {{--<div class="form-group">
                                <label for="program">Program</label>
                                <select id="program" name="program" class="form-control"></select>

                            </div>--}}
                            <div class="form-group">
                                <label for="activity">Kegiatan</label>
                                <select id="activity" name="activity" class="form-control"></select>

                            </div>
                            <div class="form-group">
                                <label for="target">Sasaran</label>
                                <select id="target" name="target" class="form-control"></select>

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

            $('#unit').on('change', function () {
                var $this = $(this);

                // $('#program').html('<option>..Loading..</option>');
                $('#activity').html('<option>..Loading..</option>');
                $('#target').html('');

               /* $.get('{{url('renstra/program/select2')}}', {
                    plan: $('#plan').val()
                }, function (response) {
                    $('#program').html(response);
                })*/

                $.get('{{url('renstra/activity/select2')}}', {
                    program: 1,
                    unit: $this.find(':selected').val()
                }, function (response) {
                    $('#activity').html(response);
                })
            });

            /*$('#program').on('change', function () {
                var $this = $(this);

                $('#activity').html('<option>..Loading..</option>');
                $('#target').html('');

                $.get('{{url('renstra/activity/select2')}}', {
                    program: $this.find(':selected').val(),
                    unit: $('#unit').find(':selected').val()
                }, function (response) {
                    $('#activity').html(response);
                })
            });*/

            $('#activity').on('change', function () {
                var $this = $(this);

                $('#target').html('<option>..Loading..</option>');

                $.get('{{url('renstra/target/select2')}}', {
                    type: 'activity',
                    typeId: $this.find(':selected').val()
                }, function (response) {
                    $('#target').html(response);
                })
            });
        });
    </script>
@stop