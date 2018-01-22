<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/x-icon" href="{{ asset('default-images/feedback_icon.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Customer Feedback</title>

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome/font-awesome.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('css/ionicons/css/ionicons.css') }}">
    <!-- Material icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/admin-lte/AdminLTE.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('css/admin-lte/_all-skins.css') }}">
    <!-- Data Table -->
    <link rel="stylesheet" href="{{ asset('css/datatables/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables/responsive.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables/responsive.bootstrap.css') }}">
    <!-- Bootstrap Select -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css" rel="stylesheet">
    <!-- Date dropper -->
    <link href="{{ asset('css/date-dropper/datedropper.css') }}" rel="stylesheet">
    <!-- Fancy Tree -->
    <link href="{{ asset('css/fancytree/skin-material/ui.fancytree.css') }}" rel="stylesheet" class="skinswitcher">
    <!-- Context Menu Dependency -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.2.3/jquery.contextMenu.min.css" />
    <!-- Icheck -->
    <link rel="stylesheet" href="{{ asset('css/icheck/all.css') }}">
    <!-- Select 2 -->
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">

    @stack('styles')

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="hold-transition skin-blue sidebar-mini">
@guest
    <div class="" style="margin-bottom: 50px;">
        @else
            <div class="wrapper">
            @endguest
            <!-- Main Header -->
                <header class="main-header">

                <!-- Logo -->
                @guest
                    <a href="{{ url('/') }}" class="logo">
                        <!-- mini logo for sidebar mini 50x50 pixels -->
                        <span class="logo-mini"><b>C</b>F</span>
                        <!-- logo for regular state and mobile devices -->
                        <span class="logo-lg"><b>Customer</b>Feedback</span>
                    </a>
                @else
                    <a href="{{ url('/home') }}" class="logo">
                        <!-- mini logo for sidebar mini 50x50 pixels -->
                        <span class="logo-mini"><b>C</b>F</span>
                        <!-- logo for regular state and mobile devices -->

                        <span class="logo-lg"><b>Customer</b>Feedback</span>
                    </a>
                @endguest

                <!-- Header Navbar -->
                    <nav class="navbar navbar-static-top" role="navigation">
                    @if(Auth::check())
                        <!-- Sidebar toggle button-->
                            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                                <span class="sr-only">Toggle navigation</span>
                            </a>
                    @endif
                    <!-- Navbar Right Menu -->
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                @guest
                                    <li>
                                        <a href="#">About</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company_login') }}">Sign in <i class="fa fa-sign-in"></i></a>
                                    </li>
                                    <li>
                                        <a href="{{ route('register') }}">Register <i class="fa fa-user-plus"></i></a>
                                    </li>
                                @else
                                    <!-- User Account Menu -->
                                    <li class="dropdown user user-menu">
                                        <!-- Menu Toggle Button -->
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <!-- The user image in the navbar-->
                                            <img src="{{ asset('default-images/admin-user.png') }}" class="user-image" alt="User Image">
                                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <!-- The user image in the menu -->
                                            <li class="user-header">
                                                <img src="{{ asset('default-images/admin-user.png') }}" class="img-circle" alt="User Image">

                                                <p>
                                                    {{ Auth::user()->name }} - {{ Auth::user()->user_group->name }}
                                                    <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                                                </p>
                                            </li>
                                            <!-- Menu Body -->
                                            <li class="user-body">
                                                <div class="row">
                                                    <div class="col-xs-4 text-center">
                                                        <a href="#">Followers</a>
                                                    </div>
                                                    <div class="col-xs-4 text-center">
                                                        <a href="#">Sales</a>
                                                    </div>
                                                    <div class="col-xs-4 text-center">
                                                        <a href="#">Friends</a>
                                                    </div>
                                                </div>
                                                <!-- /.row -->
                                            </li>
                                            <!-- Menu Footer-->
                                            <li class="user-footer">
                                                <div class="pull-left">
                                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                                </div>
                                                <div class="pull-right">
                                                    <a href="{{ route('logout') }}"
                                                       onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();"
                                                       class="btn btn-default btn-flat">Sign out</a>
                                                </div>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                    <!-- Control Sidebar Toggle Button -->
                                    {{--<li>--}}
                                        {{--<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>--}}
                                    {{--</li>--}}
                                @endguest

                            </ul>
                        </div>
                    </nav>
                </header>

                @yield('content')

            </div>
    </div>

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 3 -->
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('js/bootstrap/bootstrap.js') }}" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('js/admin-lte/adminlte.min.js') }}" type="text/javascript"></script>
    <!-- Vue JS -->
    <script src="{{ asset('js/vue/vue.js') }}" type="text/javascript"></script>
    <!-- Vee Validate -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vee-validate/2.0.3/vee-validate.js" type="text/javascript"></script>
    <!-- Axios JS -->
    <script src="https://unpkg.com/axios/dist/axios.min.js" type="text/javascript"></script>
    <!-- Data Table -->
    <script src="{{ asset('js/datatables/datatables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatables/dataTables.responsive.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatables/responsive.bootstrap.js') }}" type="text/javascript"></script>
    <!-- Jquery validation -->
    <script src="{{ asset('js/jquery-validate/jquery.validate.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/functions.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/form-validation.js') }}" type="text/javascript"></script>
    <!-- Bootstrap Select -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js" type="text/javascript"></script>
    <!-- Date dropper -->
    <script src="{{ asset('js/date-dropper/datedropper.js') }}" type="text/javascript"></script>
    <!-- Fancy Tree -->
    <script src="{{ asset('js/fancytree/jquery.fancytree-all-deps.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/fancytree/jquery.fancytree.glyph.js') }}" type="text/javascript"></script>
    <!-- Context Menu Dependency -->
    <script src="{{ asset('js/fancytree/jquery-ui.custom.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.2.3/jquery.contextMenu.min.js"></script>
    <!-- Fancy Tree Context Menu -->
    <script src="{{ asset('js/fancytree/jquery.ui-contextmenu.js') }}" type="text/javascript"></script>
    <!-- Icheck -->
    <script src="{{ asset('js/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <!-- Pretty file upload -->
    <script src="{{ asset('js/pretty-file-upload/bootstrap-prettyfile.js') }}" type="text/javascript"></script>
    <!-- Select 2 -->
    <script src="{{ asset('js/select2/select2.full.min.js') }}" type="text/javascript"></script>

    @stack('scripts')

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
