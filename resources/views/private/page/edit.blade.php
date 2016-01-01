@extends('private.layout')

@section('content')

    <div class="header-content">
        <h2><i class="fa fa-home"></i>Page</h2>

        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">You are here:</span>
            {!! breadcrumbs($breadcrumbs) !!}
        </div>
    </div>

    <div class="body-content animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="panel rounded shadow">

                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Edit: {{$page->title}}</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>


                    <div class="panel-body">
                        {!! Form::model($page, ['route' => ['page.update', $page->id], 'method' => 'PUT']) !!}

                        @if(count($errors) > 0)
                            <div class="alert alert-danger alert-dismissible fade in" role="alert" data-dismiss="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="title">Judul</label>
                            {!! Form::text('title', null, [
                                'id'    => 'title',
                                'class' => 'form-control',
                                'placeholder'   => 'Judul'
                            ]) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::textarea('content', null, [
                                'id'    => 'content',
                                'class' => 'form-control summernote',
                                'placeholder'   => 'Konten'
                            ]) !!}
                        </div>

                        <div class="form-group">
                            <label for="excerpt">Excerpt</label>
                            {!! Form::textarea('excerpt', null, [
                                'id'    => 'excerpt',
                                'class' => 'form-control',
                                'placeholder'   => 'Excerpt'
                            ]) !!}
                        </div>

                        <button type="submit" class="btn btn-info btn-block btn-lg save">
                            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Save
                        </button>

                        {!! Form::close(); !!}
                    </div>

                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')
    <script src="{{asset('lib/summernote/dist/summernote.js')}}"></script>
    <script src="{{asset('lib/elfinder/js/elfinder.full.js')}}"></script>
    <script src="{{asset('lib/jquery-ui/jquery-ui.js')}}"></script>
@stop

@section('styles')
    <link rel="stylesheet" href="{{asset('lib/summernote/dist/summernote.css')}}"/>
    <link rel="stylesheet" href="{{asset('lib/jquery-ui/themes/base/all.css')}}"/>
    <link rel="stylesheet" href="{{asset('lib/elfinder/css/elfinder.full.css')}}"/>
    <link rel="stylesheet" href="{{asset('lib/elfinder/css/theme.css')}}"/>
@stop

@section('script')
    <script>



        $(function () {
            "use strict";
            var tmpl = $.summernote.renderer.getTemplate();
            $.summernote.addPlugin({
                name: 'genixcms',
                buttons: { // buttons

                    elfinder: function () {
                        return tmpl.iconButton('fa fa-list-alt', {
                            event: 'elfinder',
                            title: 'File Manager',
                            hide: false
                        });
                    }
                },
                events: { // events

                    elfinder: function (event, editor, layoutInfo) {
                        var fm = $('<div/>').dialogelfinder({
                            url: '{{url('media/connector')}}',
                            title: 'File Manager',
                            width : 1024,
                            height: 450,
                            destroyOnClose : true,
                            getFileCallback : function(files, fm) {
                                console.log(files);

                                var $editor = $('.summernote');

                                switch(files.mime) {
                                    case 'image/jpeg':
                                        $editor.summernote('editor.insertImage',files.url);
                                        break;
                                    default:
                                        $editor.summernote('createLink', {
                                            text: files.name,
                                            url: files.url,
                                            newWindow: true
                                        });

                                }
                            },
                            commandsOptions : {
                                getfile : {
                                    oncomplete : 'close',
                                    folders : false
                                }
                            }
                        }).dialogelfinder('instance');
                    }

                }
            });
            $('.summernote').summernote({
                height: $(window).height() - 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'elfinder', 'hr']],
                    ['view', ['fullscreen', 'codeview']],
                ]
            });

            $('#excerpt').summernote({
                toolbar: [
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol']],
                    ['insert', ['link']],

                ]
            });
        });
    </script>
@stop