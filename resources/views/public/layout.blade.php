<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Kementrian PU</title>

    <link href="{{asset('lib/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{asset('css/public.css')}}" rel="stylesheet">

    <link href="{{asset('lib/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    @yield('styles')
    @yield('style')

</head>

<body>

<nav class="navbar navbar-blue navbar-fixed-top topnav" role="navigation">
    <div class="container topnav">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand topnav" href="{{url('/')}}">
                <img src="{{asset('img/logoPU.jpg')}}" alt="Kementeran PUPERA"/>
                <div class="logo-text">Kementerian PUPERA</div>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="{{route('public.page', 'tupoksi')}}">Tupoksi</a>
                </li>
                <li>
                    <a href="{{route('public.page', 'rencana-strategis')}}">Renstra</a>
                </li>
                <li>
                    <a href="{{route('public.page', 'regulasi')}}">Regulasi</a>
                </li>
                <li>
                    <a href="{{route('public.page', 'lakip')}}">e-Doc Lakip</a>
                </li>
                
                @if(Auth::check())
                <li>
                    <a href="{{url('dashboard')}}" class="btn btn-success btn-login">Dashboard</a>
                </li>
                @else
                <li>
                    <a href="{{url('login')}}" class="btn btn-success btn-login">Login</a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

@yield('content')

<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p class="copyright text-muted small">Copyright &copy; Your Company 2014. All Rights Reserved</p>
            </div>
        </div>
    </div>
</footer>

<script src="{{asset('lib/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('lib/bootstrap/dist/css/bootstrap.min.css')}}"></script>

@yield('scripts')
@yield('script')

</body>

</html>