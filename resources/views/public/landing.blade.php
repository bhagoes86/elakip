@extends('public.layout')

@section('content')

    <div class="intro-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-message">
                        <h1>Sistem Informasi Laporan Kinerja Penyediaan Perumahan</h1>
                        <hr class="intro-divider">
                        <h2>Direktorat Jenderal Penyediaan Perumahan</h2>
                        <h3>Kementerian Pekerjaan Umum dan Perumahan Rakyat</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('public.landing.intro')

    @include('public.landing.tupoksi')
    @include('public.landing.renstra')
    @include('public.landing.regulasi')
    @include('public.landing.lakip')

@stop