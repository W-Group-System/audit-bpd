<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{ URL::asset('images/icon.png')}}">

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <link href="{{ asset('login_css/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('login_css/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('login_css/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('login_css/css/style.css') }}" rel="stylesheet">
    @yield('css')
    <style>
      
        .bold-text {
            font-weight: bold;
        }
        .shownext { display: none; }
        li:hover + .shownext { display: block; }
        .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url("{{ asset('login_css/img/loader.gif') }}") 50% 50% no-repeat white;
            opacity: .8;
            background-size: 120px 120px;
        }

        .dataTables_filter {
        float: right;
        text-align: right;
        }
        .dataTables_info {
        float: left;
        text-align: left;
        }
        textarea {
    resize: vertical;
    }
    @media (min-width: 768px) {
  .modal-xl {
    width: 90%;
   max-width:1200px;
  }
}
    </style>
    <!-- Fonts -->
    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
</head>
<body class='pace-done mini-navbar'>
    <div id="loader" style="display:none;" class="loader">
    </div>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation" style="margin-bottom: 0">
            <div class="sidebar-collapse">
                <ul class="nav metismenu tooltip-demo" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                                <img alt="image" class="img-circle" style='width:50px;' src="{{asset('images/no_image.png')}}" />
                            </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{auth()->user()->name}}</strong>
                                 </span> <span class="text-muted text-xs block">{{auth()->user()->role->name}} <b class="caret"></b></span> </span> </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="#" data-toggle="modal" data-target="#userChangePassword">Change Password</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            
                            <img alt="image" class="img-circle" style='width:50px;' src="{{asset('images/no_image.png')}}" />
                        </div>
                        
                    </li>
                    <!-- //sidebar -->
                    <li class="{{ Route::current()->getName() == 'home' ? 'active' : '' }} shownext" data-toggle="tooltip" data-placement="right" title="Dashboard">
                        <a href="{{url('/home')}}"><i class="fa fa-th-large"></i> <span
                                class="nav-label " >Dashboard </span></a>
                    </li>
                    <li class="{{ Request::is('corrective-action-request') ? 'active' : '' }} shownext" data-toggle="tooltip" data-placement="right" title="Corrective Action Request">
                        <a href="{{url('/corrective-action-request')}}"><i class="fa fa-file"></i> <span
                                class="nav-label " >Corrective Action Request </span></a>
                    </li>
                    @if(auth()->user()->role->name == 'Auditor' || auth()->user()->role->name == 'Audit Head' || auth()->user()->role->name == 'Administrator')
                    <li class="{{ Request::is('for-approval') ? 'active' : 'for-approval' }} shownext" data-toggle="tooltip" data-placement="right" title="For Approval">
                        <a href="{{url('/for-approval')}}"><i class="fa fa-check"></i> <span
                                class="nav-label " >For Approval </span></a>
                    </li>
                    @endif
                    @if(auth()->user()->role->name == 'Administrator')
                    <li class="{{ Route::current()->getName() == 'settings' ? 'active' : '' }}" data-toggle="tooltip" data-placement="right" title="Settings">
                        <a href="#"><i class="fa fa-cog"></i> <span class="nav-label">Settings</span><span
                                class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li ><a href="{{url('/companies')}}"></i>Companies</a></li>
                            <li><a href="{{url('/departments')}}"></i>Departments</a></li>
                            <li><a href="{{url('/users')}}"></i>Users</a></li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i
                                class="fa fa-bars"></i>
                             </a>
                            
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <span class="m-r-sm text-muted welcome-message" title='For Approval'>Welcome to {{ config('app.name', 'Laravel') }}</span>
                        </li>
                        <li>
                            <a class=" count-info " href="{{url('/for-approval')}}" title='For Approval'>
                                <i class="fa fa-bell"></i>  <span class="label label-warning"></span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="logout(); show();">
                                <i class="fa fa-sign-out"></i> Log out
                            </a>
                        </li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </nav>
            </div>
            @yield('content')
            <div class="footer">
                <div class='text-right'>
                    WGROUP DEVELOPER &copy; {{date('Y')}}
                </div>
            </div>
        </div>
    </div>
    @include('user_change_pass')

    @include('sweetalert::alert')
    <script src="{{ asset('login_css/js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{ asset('login_css/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('login_css/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{ asset('login_css/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    <script src="{{ asset('login_css/js/inspinia.js')}}"></script>
    <script src="{{ asset('login_css/js/plugins/pace/pace.min.js')}}"></script>
    <!-- d3 and c3 charts -->
    <script src="{{ asset('login_css/js/plugins/d3/d3.min.js') }}"></script>
    <script src="{{ asset('login_css/js/plugins/c3/c3.min.js') }}"></script>

    <script>
        function show() {
            document.getElementById("loader").style.display = "block";
        }

        function logout() {
            event.preventDefault();
            document.getElementById('logout-form').submit();
        }

        function addRow()
        {
            var id = $("#correctiveActionContainer").children().last().attr('id')
            var lastId = id.split('_') 
            var displayNum = parseInt(lastId[1]) + 1

            $("#correctiveActionContainer").append(`
                <div class="row" id="caNum_${displayNum}">
                    <div class="col-md-1">
                        ${displayNum}
                    </div>
                    <div class="col-md-6">
                        <textarea name="corrective_action[]" class="form-control" cols="30" required></textarea>
                    </div>
                    <div class="col-md-5">
                        <input type="date" name="action_date[]" class="form-control input-sm" required>
                    </div>
                </div>
            `)
        }
    </script>
    @yield('js')

</body>
</html>
