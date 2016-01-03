@extends('private.layout')

@section('content')
    <div class="header-content">
        <h2><i class="fa fa-home"></i>Evaluasi kinerja</h2>

    </div>

    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-md-12">
                <div class="panel rounded shadow">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Detail evaluasi kinerja</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped table-condensed">
                            {{--<tr>
                                <th>Id</th>
                                <td>: <a href="{{route('perjanjian-kerja.program.index', $agreement->id)}}">{{$agreement->id}}</a></td>
                            </tr>--}}
                            <tr>
                                <th>Tahun</th>
                                <td>: {{$agreement->year}}</td>
                            </tr>
                            <tr>
                                <th>Pihak pertama</th>
                                <td>: {{$agreement->firstPosition->user->name}}</td>
                            </tr>
                            <tr>
                                <th>Pihak kedua</th>
                                <td>: {{$agreement->secondPosition->user->name}}</td>
                            </tr>
                            <tr>
                                <th>Program</th>
                                <td>: {{$activity->program->name}}</td>
                            </tr>
                            <tr>
                                <th>Kegiatan</th>
                                <td>: <strong>{{$activity->name}}</strong></td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>


        {!! Form::open([
            'route' => ['kegiatan.agreement.evaluasi.store', $activity->id, $agreement->id]
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

                        <textarea name="issue" id="issue" class="summernote"></textarea>

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
                        <textarea name="solutions" id="solutions" class="summernote"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Save
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