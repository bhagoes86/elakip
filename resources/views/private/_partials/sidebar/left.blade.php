{{--

START @SIDEBAR LEFT
|=========================================================================================================================|
|  TABLE OF CONTENTS (Apply to sidebar left class)                                                                        |
|=========================================================================================================================|
|  01. sidebar-box               |  Variant style sidebar left with box icon                                              |
|  02. sidebar-rounded           |  Variant style sidebar left with rounded icon                                          |
|  03. sidebar-circle            |  Variant style sidebar left with circle icon                                           |
|=========================================================================================================================|

--}}
<aside id="sidebar-left" class="sidebar-warning sidebar-circle">

    <!-- Start left navigation - profile shortcut -->
    <div id="tour-8" class="sidebar-content">
        <div class="media">
            <a class="pull-left has-notif avatar" href="#">
                <img src="{{asset('img/profile.png')}}" alt="admin">
                <i class="online"></i>
            </a>
            <div class="media-body">
                <h4 class="media-heading"><span>{{$authUser->name}}</span></h4>
                <small>{{$authUser->role->name}}</small>
            </div>
        </div>
    </div><!-- /.sidebar-content -->
    <!--/ End left navigation -  profile shortcut -->

    <!-- Start left navigation - menu -->
    <ul id="tour-9" class="sidebar-menu">

        <li id="dashboard">
            <a href="{{route('dashboard')}}">
                <span class="icon"><i class="fa fa-home"></i></span>
                <span class="text">Dashboard</span>

            </a>
        </li>

        @if(!Gate::check('read-only'))
        <li id="persiapan-pk">
            <a href="{{route('renstra.index')}}">
                <span class="icon"><i class="fa fa-home"></i></span>
                <span class="text">Persiapan PK</span>

            </a>
        </li>
        @endcan

        <li class="submenu" id="perjanjian">
            <a href="javascript:void(0)">
                <span class="icon">
                    <i class="fa fa-home"></i>
                </span>
                <span class="text">Perjanjian Kinerja</span>
                <span class="arrow"></span>
            </a>
            <ul>
                @if(!Gate::check('read-only'))
                <li id="perjanjian-baru"><a href="{{route('pk.create')}}">Buat baru</a></li>
                @endif

                <li id="perjanjian-daftar"><a href="{{route('pk.index')}}">Daftar perjanjian kinerja</a></li>
                {{-- <li><a href="{{route('pk.index')}}">Tanpa PK</a></li> --}}
            </ul>
        </li>

        <li class="submenu" id="capaian">
            <a href="javascript:void(0)">
                <span class="icon">
                    <i class="fa fa-home"></i>
                </span>
                <span class="text">Capaian Kinerja</span>
                <span class="arrow"></span>
            </a>
            <ul>
                {{--<li><a href="{{route('capaian.fisik.filter')}}">Kegiatan Fisik Triwulan</a></li>--}}
                <li id="capaian-kegiatan"><a href="{{route('capaian.renstra.fisik.filter')}}">Sasaran Program/Kegiatan</a></li>
                <li id="capaian-anggaran-tahun"><a href="{{route('capaian.anggaran.filter')}}">Anggaran Per Tahun</a></li>
                <li id="capaian-anggaran-periode"><a href="{{route('capaian.renstra.anggaran.filter')}}">Anggaran Per Periode</a></li>
            </ul>
        </li>
{{--
        <li>
            <a href="">Kegiatan Prioritas</a>
        </li>--}}

        <li id="evaluasi">
            <a href="{{route('kegiatan.evaluasi.filter')}}">
                <span class="icon"><i class="fa fa-home"></i></span>
                <span class="text">Evaluasi Kinerja</span>
            </a>
        </li>

        @can('read-user', null)
        <li class="submenu" id="content">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-home"></i></span>
                <span class="text">Content</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li id="content-page"><a href="{{route('page.index')}}">Page</a></li>

            </ul>
        </li>
        @endcan

        @can('read-user', null)
        <li class="submenu" id="setting">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-home"></i></span>
                <span class="text">Pengaturan</span>
                <span class="arrow"></span>

                {{--<span class="selected"></span>--}}
            </a>
            <ul>
                <li id="setting-user"><a href="{{route('user.index')}}">User</a></li>
                <li id="setting-position"><a href="{{route('position.index')}}">Jabatan user</a></li>
            </ul>
        </li>
        @endcan


    </ul><!-- /.sidebar-menu -->
    <!--/ End left navigation - menu -->

    <!-- Start left navigation - footer -->
    {{--<div id="tour-10" class="sidebar-footer hidden-xs hidden-sm hidden-md">
        <a id="setting" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Setting"><i class="fa fa-cog"></i></a>
        <a id="fullscreen" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Fullscreen"><i class="fa fa-desktop"></i></a>
        <a id="lock-screen" data-url="page-signin.html" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Lock Screen"><i class="fa fa-lock"></i></a>
        <a id="logout" data-url="page-lock-screen.html" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Logout"><i class="fa fa-power-off"></i></a>
    </div>--}}<!-- /.sidebar-footer -->
    <!--/ End left navigation - footer -->

</aside><!-- /#sidebar-left -->
<!--/ END SIDEBAR LEFT -->