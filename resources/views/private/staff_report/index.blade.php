@extends('private.layout')

@section('content')

    <div class="header-content">
        <h2><i class="fa fa-home"></i>Laporan Staff</h2>
    </div>

    <div class="body-content animated fadeIn">

        <div class="row">

            <div class="col-md-12">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Filter Staff</h3>
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

        <div class="row">

            <div class="col-md-12">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Daftar Staff</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                       <table class="table table-condensed table-striped table-bordered">
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
                       </table>

                    </div>
                </div>
            </div>
        </div>
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