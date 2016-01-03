@extends('private.layout')

@section('content')
    <div class="header-content">
        <h2><i class="fa fa-home"></i>Evaluasi</h2>
        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">You are here:</span>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="#">Pengaturan</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    Year
                </li>
            </ol>
        </div>
    </div>

    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-md-12">
                <div class="panel rounded shadow">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">...</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

                    </div>
                </div>
            </div>
        </div>


        {!! Form::model($evaluation, [
            'route' => ['kegiatan.evaluasi.update', $evaluation->activity->id, $evaluation->id],
            'method'    => 'PUT'
        ]) !!}

        <div class="row">

            <div class="col-md-6">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Kendala</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">

                        {!! Form::textarea('issue', null, [
                            'class' => 'summernote',
                            'id'    => 'issue'
                        ]) !!}

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Tindak lanjut</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        {!! Form::textarea('solutions', null, [
                            'class' => 'summernote',
                            'id'    => 'solutions'
                        ]) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Update
                </button>
            </div>
        </div>

        {!! Form::close() !!}
    </div>

    @include('private._partials.modal')
@stop

@section('scripts')
    <script src="{{asset('lib/summernote/dist/summernote.js')}}"></script>

@stop

@section('styles')
    <link rel="stylesheet" href="{{asset('lib/summernote/dist/summernote.css')}}"/>
@stop

@section('script')
    <script>
        $(function(){
            $('.summernote').summernote({
                height: $(window).height() - 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline']],
                    ['para', ['ol', 'paragraph']],
                    ['insert', ['link',]],
                    ['view', ['fullscreen', 'codeview']],
                ]
            });
        })
    </script>
@stop