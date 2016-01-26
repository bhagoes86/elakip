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
                        <form action="{{route('capaian.fisik.indicator')}}" method="get">
                            {{--<div class="form-group">
                                <label for="year">Rencana Strategis</label>
                                {!! Form::select('plan', $plans, null, [
                                    'placeholder' => '-Select Renstra-',
                                    'class' => 'form-control',
                                    'id'=>'plan']) !!}
                            </div>--}}
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
                            {{--<div class="form-group">
                                <label for="program">Program</label>
                                {!! Form::select('program', $programs, $id['program'], [
                                    'placeholder' => '-Select Program-',
                                    'class' => 'form-control',
                                    'id'=>'program']) !!}

                            </div>--}}
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
                            <h3 class="panel-title">Indicator</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped table-bordered" id="{{$viewId}}-datatables">
                            <thead>
                            <tr>
                                <th>Nama indikator</th>
                                <th>Target</th>
                                <th>Unit</th>
                            </tr>
                            </thead>
                        </table>
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


            var table = $('#{{$viewId}}-datatables').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{route('capaian.fisik.indicator.data')}}",
                    data: function(d) {
                        d.year = {{$id['year']}};
                        d.agreement = {{$id['agreement']}};
                        d.program = {{$id['program']}};
                        d.activity = {{$id['activity']}};
                        d.target = {{$id['target']}};
                    }
                },
                columns: [
                    {data:'name',name:'name'},
                    {data:'first_goal_count',name:'first_goal_count'},
                    {data:'unit',name:'unit'}
                ]
            });



         /*   $('#target').select2({
                placeholder: "-Pilih Sasaran-"
            });*/


            $('#year').on('change', function () {
                var $this = $(this);

                $('#agreement').html('<option>...Loading...</option>');
                //$('#program').html('');
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

                $('#activity').html('<option>...Loading...</option>');
                $('#target').html('');


                $.get('{{route('kegiatan.select2')}}', {
                    program: 1, //$this.find(':selected').val(),
                    agreement: $this.find(':selected').val()
                }, function (response) {
                    $('#activity').html(response);
                })
            });



            $('#activity').on('change', function () {
                var $this = $(this);

                $('#target').html('<option>...Loading...</option>');

                $.get('{{route('sasaran.select2')}}', {
                    activity: $this.find(':selected').val()
                }, function (response) {
                    $('#target').html(response);
                })
            });


        });
    </script>
@stop