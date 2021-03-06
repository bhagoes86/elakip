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
                        <form action="{{route('capaian.anggaran.kegiatan')}}" method="get">
                            {!! Form::hidden('plan', $plan->id, ['id' => 'plan']) !!}

                            <div class="form-group">
                                <label for="year">Tahun</label>
                                {!! Form::select('year', $years, $id['year'], [
                                    'placeholder' => '-Select Year-',
                                    'class' => 'form-control',
                                    'id'=>'year']) !!}
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
                        <table class="table table-striped table-bordered" id="{{$viewId}}-datatables">
                            <thead>
                            <tr>
                                <th>Unit</th>
                                <th>Nama kegiatan</th>
                                <th>Anggaran</th>
                                <th>Realisasi</th>
                                <th>%</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($activities as $activity)
                                <tr>
                                    <td>{{$activity->unit->name}}</td>
                                    <td>{{$activity->name}}</td>
                                    <td>
                                        @if($activity->budget != null)
                                            {{money_format('%.2n', $activity->budget->pagu)}}
                                        @else
                                            {{money_format('%.2n', 0)}}
                                        @endif
                                    </td>
                                    <td>
                                        @can('read-only')
                                            @if($activity->budget != null)
                                                {{money_format('%.2n', $activity->budget->realization)}}
                                            @else
                                                {{money_format('%.2n', 0)}}
                                            @endif
                                        @else
                                            @if($activity->budget != null)
                                                <a href="#"
                                                   class="x-editable"
                                                   id="realization-{{$activity->budget->id}}"
                                                   data-value="{{$activity->budget->realization}}"
                                                   data-type="text"
                                                   data-pk="{{$activity->budget->id}}"
                                                   data-url="{{route('capaian.anggaran.kegiatan.update', [$activity->budget->id])}}"
                                                   data-title="Realisasi">{{$activity->budget->realization}}</a>
                                            @else
                                                {{money_format('%.2n', 0)}}
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if($activity->budget != null)
                                            <span id="percent-{{$activity->budget->id}}">
                                            {{ round($activity->budget->realization / $activity->budget->pagu * 100, 2) }}%
                                            </span>
                                        @else
                                            {{0}}%
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
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
    <script src="{{asset('lib/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min.js')}}"></script>
    <script src="{{asset('lib/select2/dist/js/select2.min.js')}}"></script>
@stop

@section('styles')
    <link rel="stylesheet" href="{{asset('lib/datatables/media/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('lib/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css')}}"/>
    <link rel="stylesheet" href="{{asset('lib/select2/dist/css/select2.min.css')}}"/>
@stop

@section('script')
    <script type="text/javascript">
        $(function() {
            "use strict";


            $('.x-editable').editable({
                display: function(value) {
                    $(this).text('Rp'+formatMoney(value, 2, ',', '.'));
                },
                params: function (params) {
                    params._token = '{{csrf_token()}}';
                    params._method = 'PUT';
                    return params;
                },
                success: function (data, config){
                    console.log(data);
                    var p = data.realization / data.pagu * 100;
                    $('#percent-'+data.id).html(p.toFixed(2) + '%');
                }
            });
        });
    </script>
@stop