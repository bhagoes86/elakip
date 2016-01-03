@extends('public.layout')

@section('content')
    <div class="container heading">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title">{!! $page->title !!}</h2>
                <hr class="section-heading-spacer"/>
                <div class="clearfix"></div>
                <div class="content">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
@stop