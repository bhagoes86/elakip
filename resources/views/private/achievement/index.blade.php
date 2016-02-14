@extends('private.layout')

@section('content')
    <div class="header-content">
        <h2><i class="fa fa-home"></i>Capaian Kinerja Kegiatan Fisik</h2>
    </div>

    <div class="body-content animated fadeIn">

        <div class="row mbot-15">
            <div class="col-md-12">
                <a href="{{route('capaian.fisik.indicator')}}?plan={{$activity->program->plan->id}}&year={{$goal->year}}&agreement={{$agreement->id}}&program={{$activity->program->id}}&activity={{$activity->id}}&target={{$goal->indicator->target->id}}" class="btn btn-danger">
                    <i class="fa fa-arrow-left"></i> Back
                </a>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel rounded shadow">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Detail capaian kinerja</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped table-condensed">
                            <tr>
                                <th>Tahun</th>
                                <td>: {{$goal->year}}</td>
                            </tr>
                            {{--<tr>
                                <th>Pihak pertama</th>
                                <td>: {{$indicator->target->activity->program->agreement->first_user_unit->user->name}}</td>
                            </tr>
                            <tr>
                                <th>Pihak kedua</th>
                                <td>: {{$indicator->target->activity->program->agreement->second_user_unit->user->name}}</td>
                            </tr>
                            <tr>
                                <th>Program</th>
                                <td>: {{$indicator->target->activity->program->name}}</td>
                            </tr>
                            <tr>
                                <th>Kegiatan</th>
                                <td>: {{$indicator->target->activity->name}}</td>
                            </tr>--}}
                            <tr>
                                <th>Sasaran</th>
                                <td>: {{$goal->indicator->target->name}}</td>
                            </tr>
                            <tr>
                                <th>Indicator</th>
                                <td>: <strong>{{$goal->indicator->name}}</strong></td>
                            </tr>
                            <tr>
                                <th>Target</th>
                                <td>: <strong>{{$goal->count}} {{$goal->indicator->unit}}</strong></td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            @if($goal->with_detail)

                @include('private.achievement.quarter_detail', [
                    'id' => 'tw1',
                    'panel_title' => 'Triwulan I',
                    'key' => 'first_quarter'
                ])
                @include('private.achievement.quarter_detail', [
                    'id' => 'tw2',
                    'panel_title' => 'Triwulan II',
                    'key' => 'second_quarter'
                ])
                @include('private.achievement.quarter_detail', [
                    'id' => 'tw3',
                    'panel_title' => 'Triwulan III',
                    'key' => 'third_quarter'
                ])
                @include('private.achievement.quarter_detail', [
                    'id' => 'tw4',
                    'panel_title' => 'Triwulan IV',
                    'key' => 'fourth_quarter'
                ])
            @else

                @include('private.achievement.quarter_detail', [
                    'id' => 'tw1',
                    'panel_title' => 'Triwulan I',
                    'key' => 'first_quarter'
                ])
                @include('private.achievement.quarter_detail', [
                    'id' => 'tw2',
                    'panel_title' => 'Triwulan II',
                    'key' => 'second_quarter'
                ])
                @include('private.achievement.quarter_detail', [
                    'id' => 'tw3',
                    'panel_title' => 'Triwulan III',
                    'key' => 'third_quarter'
                ])
                @include('private.achievement.quarter_detail', [
                    'id' => 'tw4',
                    'panel_title' => 'Triwulan IV',
                    'key' => 'fourth_quarter'
                ])
            @endif

        </div>
    </div>

    @include('private._partials.modal_large')
@stop

@section('scripts')
    <script src="{{asset('lib/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('lib/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('lib/dropzone/dist/dropzone.js')}}"></script>
    <script src="{{asset('lib/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min.js')}}"></script>

@stop

@section('styles')
    <link rel="stylesheet" href="{{asset('lib/datatables/media/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('lib/dropzone/dist/dropzone.css')}}"/>
    <link rel="stylesheet" href="{{asset('lib/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css')}}"/>

@stop

@section('script')
<script>
    $('.btn-documents').click(function(){
        var $this = $(this);

        $('#{{$viewId}}-lg .modal-title').html($this.html());

        $.get('{{route('quarter.detail.edit')}}', {
            goal: '{{$goal->id}}',
            tw: $this.data('tw').split('tw')[1],
            achievement: $this.data('achievementId')
        }, function(response) {
            $('#{{$viewId}}-lg .modal-body').html(response);
        });

        $('#{{$viewId}}-lg').modal('show');
    });
</script>
@stop