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
                            {!! Form::select('organization', $organizations, null, ['class' => 'form-control', 'placeholder' => '- Pilih Organisasi -']) !!}
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i> Filter
                        </button>
                        {!! Form::close() !!}

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