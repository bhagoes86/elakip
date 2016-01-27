@extends('private.layout')

@section('content')

    <div class="header-content">
        <h2><i class="fa fa-home"></i>Laporan SDM</h2>
    </div>

    <div class="body-content animated fadeIn">

        <div class="row">

            <div class="col-md-12">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Filter SDM</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        {!! Form::open(['route' => 'sdm.report.index', 'method' => 'get']) !!}
                        <div class="form-group">
                            <label for="organizations">Organisasi</label>
                            {!! Form::select('organization', $organizations, $organization->id, ['class' => 'form-control', 'placeholder' => '- Pilih Organisasi -']) !!}
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i> Filter
                        </button>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>

        @if($organization->getLevel() == 0 || $organization->getLevel() == 1)
        <div class="row">
            <div class="col-md-12">
                <div class="panel rounded shadow">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Rekap SDM</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-condensed table-striped table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center" rowspan="2">Status pegawai</th>
                                <th class="text-center" colspan="6">Jenjang Pendididkan</th>
                            </tr>
                            <tr>
                                <th class="text-center">SMA</th>
                                <th class="text-center">D3</th>
                                <th class="text-center">S1</th>
                                <th class="text-center">S2</th>
                                <th class="text-center">S3</th>
                                <th class="text-center">Total</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr>
                                <td>PNS</td>
                                <td>{{$rekap['pns']['sma']}}</td>
                                <td>{{$rekap['pns']['d3']}}</td>
                                <td>{{$rekap['pns']['s1']}}</td>
                                <td>{{$rekap['pns']['s2']}}</td>
                                <td>{{$rekap['pns']['s3']}}</td>
                                <td>{{$rekap['pns']['total']}}</td>
                            </tr>
                            <tr>
                                <td>Non PNS</td>
                                <td>{{$rekap['non_pns']['sma']}}</td>
                                <td>{{$rekap['non_pns']['d3']}}</td>
                                <td>{{$rekap['non_pns']['s1']}}</td>
                                <td>{{$rekap['non_pns']['s2']}}</td>
                                <td>{{$rekap['non_pns']['s3']}}</td>
                                <td>{{$rekap['non_pns']['total']}}</td>
                            </tr>
                            </tbody>

                            <tfoot>
                            <tr>
                                <th>Total</th>
                                <th>{{$rekap['pns']['sma'] + $rekap['non_pns']['sma']}}</th>
                                <th>{{$rekap['pns']['d3'] + $rekap['non_pns']['d3']}}</th>
                                <th>{{$rekap['pns']['s1'] + $rekap['non_pns']['s1']}}</th>
                                <th>{{$rekap['pns']['s2'] + $rekap['non_pns']['s2']}}</th>
                                <th>{{$rekap['pns']['s3'] + $rekap['non_pns']['s3']}}</th>
                                <th>{{$rekap['pns']['total'] + $rekap['non_pns']['total']}}</th>

                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($organization->getLevel() > 1)
        <div class="row">

            <div class="col-md-12">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Daftar SDM</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                       <table class="table table-condensed table-striped table-bordered">
                           <thead>
                           <tr>
                               <th rowspan="2" class="text-center">No</th>
                               <th rowspan="2" class="text-center">Nama</th>
                               <th rowspan="2" class="text-center">Jabatan</th>
                               <th rowspan="2" class="text-center">Status</th>
                               <th colspan="4" class="text-center">Pendidikan</th>
                           </tr>
                           <tr>
                               <th class="text-center">S3</th>
                               <th class="text-center">S2</th>
                               <th class="text-center">S1</th>
                               <th class="text-center">SLTA</th>
                           </tr>
                           </thead>

                           <tbody>
                           <?php $i = 1; ?>
                           @foreach($organization->staff as $staff)
                           <tr>
                               <td>{{$i}}</td>
                               <td>{{$staff->name}}</td>
                               <td>{{$staff->position}}</td>
                               <td>{{strtoupper($staff->status)}}</td>

                               <?php
                               $educationCollection = [];
                               foreach ($staff->education as $education) {
                                   $educationCollection[$education->level] = [];
                                   array_push($educationCollection[$education->level], $education->toArray());
                               }

                                  #  dd($educationCollection);

                               ?>
                               <td>
                                   @if(isset($educationCollection['s3']))
                                       @foreach($educationCollection['s3'] as $item)
                                           {{$item['major']}},
                                       @endforeach
                                   @else
                                       -
                                   @endif
                               </td>
                               <td>
                                   @if(isset($educationCollection['s2']))
                                       @foreach($educationCollection['s2'] as $item)
                                           {{$item['major']}},
                                       @endforeach
                                   @else
                                       -
                                   @endif
                               </td>
                               <td>
                                   @if(isset($educationCollection['s1']))
                                       @foreach($educationCollection['s1'] as $item)
                                           {{$item['major']}},
                                       @endforeach
                                   @else
                                       -
                                   @endif
                               </td>
                               <td>
                                   @if(isset($educationCollection['sma']))
                                       @foreach($educationCollection['sma'] as $item)
                                           SLTA
                                       @endforeach
                                   @else
                                       -
                                   @endif
                               </td>

                           </tr>
                               <?php $i++; ?>
                           @endforeach
                           </tbody>

                           <tfoot>
                           <tr class="info">
                               <th colspan="2">Total</th>
                               <th>&nbsp;</th>
                               <th>{{count($resume['s3']) + count($resume['s2']) + count($resume['s1']) + count($resume['sma']) + count($resume['smp'])}}</th>
                               <th>{{count($resume['s3']) == 0 ? '-' : count($resume['s3'])}}</th>
                               <th>{{count($resume['s2']) == 0 ? '-' : count($resume['s2'])}}</th>
                               <th>{{count($resume['s1']) == 0 ? '-' : count($resume['s1'])}}</th>
                               <th>{{count($resume['sma']) == 0 ? '-' : count($resume['sma'])}}</th>
                           </tr>
                           </tfoot>
                       </table>

                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    @include('private._partials.modal')
@stop

@section('scripts')
@stop

@section('styles')
@stop

@section('script')
    <script type="text/javascript">
        $(function() {
            "use strict";


        });
    </script>
@stop