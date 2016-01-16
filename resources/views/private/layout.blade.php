<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

<head>
    {{-- START @META SECTION --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Direktorat Jenderal Penyediaan Perumahan">
    <meta name="keywords" content="kementerian, pupera, fathur, akung, rohman, indonesia">
    <meta name="author" content="Fathur Rohman">
    <title>Direktorat Jenderal Penyediaan Perumahan</title>
    {{--/ END META SECTION --}}

    {{-- START @FAVICONS --}}
    <link href="http://themes.djavaui.com/blankon-fullpack-admin-theme/img/ico/html/apple-touch-icon-144x144-precomposed.png" rel="apple-touch-icon-precomposed" sizes="144x144">
    <link href="http://themes.djavaui.com/blankon-fullpack-admin-theme/img/ico/html/apple-touch-icon-114x114-precomposed.png" rel="apple-touch-icon-precomposed" sizes="114x114">
    <link href="http://themes.djavaui.com/blankon-fullpack-admin-theme/img/ico/html/apple-touch-icon-72x72-precomposed.png" rel="apple-touch-icon-precomposed" sizes="72x72">
    <link href="http://themes.djavaui.com/blankon-fullpack-admin-theme/img/ico/html/apple-touch-icon-57x57-precomposed.png" rel="apple-touch-icon-precomposed">
    <link href="http://themes.djavaui.com/blankon-fullpack-admin-theme/img/ico/html/apple-touch-icon.png" rel="shortcut icon">
    {{--/ END FAVICONS --}}

    {{-- START @FONT STYLES --}}
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Oswald:700,400" rel="stylesheet">
    {{--/ END FONT STYLES --}}

    <link href="{{asset('lib/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    {{--<link href="{{asset('lib/animate.css/animate.min.css')}}" rel="stylesheet">--}}


    @yield('styles')

    {{-- START @THEME STYLES --}}
    <link href="{{asset('css/reset.css')}}" rel="stylesheet">
    <link href="{{asset('css/layout.css')}}" rel="stylesheet">
    <link href="{{asset('css/components.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins.css')}}" rel="stylesheet">
    <link href="{{asset('css/themes/pupera.css')}}" rel="stylesheet" id="theme">
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    {{--/ END THEME STYLES --}}

    {{-- START @IE SUPPORT --}}
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="{{asset('lib/html5shiv/dist/html5shiv.min.js')}}"></script>
    <script src="{{asset('lib/respond-minmax/dest/respond.min.js')}}"></script>
    <![endif]-->
    <!--/ END IE SUPPORT -->
    <script>
        var baseUrl = '{{url('/')}}';
    </script>
    @yield('style')
</head>

<body class="page-session page-sound page-header-fixed page-sidebar-fixed demo-dashboard-session">

<!--[if lt IE 9]>
<p class="upgrade-browser">Upps!! You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" target="_blank">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- START @WRAPPER -->
<section id="wrapper">

    @include('private._partials.header')
    @include('private._partials.sidebar.left')

    <div id="page-content">
        @yield('content')
    </div>

    {{--@include('private._partials.sidebar.right')--}}

</section><!-- /#wrapper -->
<!--/ END WRAPPER -->

<!-- START @BACK TOP -->
<div id="back-top" class="animated pulse circle">
    <i class="fa fa-angle-up"></i>
</div><!-- /#back-top -->
<!--/ END BACK TOP -->

<!-- START JAVASCRIPT SECTION (Load javascripts at bottom to reduce load time) -->
<!-- START @CORE PLUGINS -->
<script src="{{asset('lib/jquery-1.11/dist/jquery.min.js')}}"></script>
{{--<script src="{{asset('lib/jquery/jquery.js')}}"></script>--}}
<script src="{{asset('lib/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('lib/jquery-cookie/jquery.cookie.js')}}"></script>
<script src="{{asset('lib/handlebars/handlebars.js')}}"></script>
<script src="{{asset('lib/typehead.js/dist/typeahead.bundle.min.js')}}"></script>
<script src="{{asset('lib/jquery-nicescroll/jquery.nicescroll.min.js')}}"></script>
<script src="{{asset('lib/jquery.sparkline.min/index.js')}}"></script>
<script src="{{asset('lib/jquery-easing-original/jquery.easing.min.js')}}"></script>
<script src="{{asset('lib/ionsound/js/ion.sound.min.js')}}"></script>
<script src="{{asset('lib/bootbox.js/bootbox.js')}}"></script>
<!--/ END CORE PLUGINS -->

<script src="{{asset('js/apps.js')}}"></script>
<script src="{{asset('js/silap.js')}}"></script>


@yield('scripts')

@yield('script')
</body>
<!--/ END BODY -->

</html>
