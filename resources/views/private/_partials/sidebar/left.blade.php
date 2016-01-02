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
<aside id="sidebar-left" class="sidebar-circle">

    <!-- Start left navigation - profile shortcut -->
    <div id="tour-8" class="sidebar-content">
        <div class="media">
            <a class="pull-left has-notif avatar" href="page-profile.html">
                <img src="http://img.djavaui.com/?create=50x50,4888E1?f=ffffff" alt="admin">
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

        <li>
            <a href="{{route('dashboard')}}">
                <span class="icon"><i class="fa fa-home"></i></span>
                <span class="text">Dashboard</span>

            </a>
        </li>

        <li>
            <a href="{{route('renstra.index')}}">
                <span class="icon"><i class="fa fa-home"></i></span>
                <span class="text">Rencana Strategis</span>

            </a>
        </li>

        <li class="submenu">
            <a href="javascript:void(0)">
                <span class="icon">
                    <i class="fa fa-home"></i>
                </span>
                <span class="text">Perjanjian kinerja</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li><a href="{{route('pk.create')}}">Buat baru</a></li>
                <li><a href="{{route('pk.index')}}">Daftar perjanjian kinerja</a></li>
            </ul>
        </li>

        <li class="submenu">
            <a href="javascript:void(0)">
                <span class="icon">
                    <i class="fa fa-home"></i>
                </span>
                <span class="text">Capaian Kinerja</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li><a href="{{route('capaian.fisik.filter')}}">Kegiatan Fisik</a></li>
                <li><a href="{{route('capaian.anggaran.filter')}}">Anggaran</a></li>
                <li><a href="{{route('capaian.renstra.fisik.filter')}}">Kegiatan Fisik Renstra</a></li>
                <li><a href="{{route('capaian.renstra.anggaran.filter')}}">Anggaran Renstra</a></li>
            </ul>
        </li>

        {{--<li>
            <a href="{{route('evaluation.filter')}}">
                <span class="icon"><i class="fa fa-home"></i></span>
                <span class="text">Evaluasi Kinerja</span>

            </a>
        </li>--}}

        @can('read-user', null)
        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-home"></i></span>
                <span class="text">Content</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li class=""><a href="{{route('page.index')}}">Page</a></li>

            </ul>
        </li>
        @endcan

        @can('read-user', null)
        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-home"></i></span>
                <span class="text">Pengaturan</span>
                <span class="arrow"></span>
                <span class="selected"></span>
            </a>
            <ul>
                <li><a href="{{route('user.index')}}">User</a></li>
                <li><a href="{{route('position.index')}}">Jabatan user</a></li>
            </ul>
        </li>
        @endcan


    </ul><!-- /.sidebar-menu -->
    <!--/ End left navigation - menu -->

    <!-- Start left navigation - footer -->
    <div id="tour-10" class="sidebar-footer hidden-xs hidden-sm hidden-md">
        <a id="setting" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Setting"><i class="fa fa-cog"></i></a>
        <a id="fullscreen" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Fullscreen"><i class="fa fa-desktop"></i></a>
        <a id="lock-screen" data-url="page-signin.html" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Lock Screen"><i class="fa fa-lock"></i></a>
        <a id="logout" data-url="page-lock-screen.html" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Logout"><i class="fa fa-power-off"></i></a>
    </div><!-- /.sidebar-footer -->
    <!--/ End left navigation - footer -->

</aside><!-- /#sidebar-left -->
<!--/ END SIDEBAR LEFT -->