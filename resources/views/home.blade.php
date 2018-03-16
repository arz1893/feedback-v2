@extends('layouts.app')

@section('content')
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ asset('default-images/admin-user.png') }}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>

            <!-- search form (Optional) -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
                </div>
            </form>
            <!-- /.search form -->

            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MAIN NAVIGATION</li>
                <li class="">
                    <a href="{{ url('/home') }}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bars"></i> <span>Main Menu</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href="#!">
                                <i class="ion ion-clipboard"></i> FAQ
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>

                            <ul class="treeview-menu">
                                <li><a href="{{ route('faq_product.index') }}"><i class="ion ion-android-bookmark"></i> FAQ Product</a></li>
                                <li><a href="{{ route('faq_service.index') }}"><i class="ion ion-android-bookmark"></i> FAQ Service</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#!">
                                <i class="ion ion-settings"></i> Complaints
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ route('complaint_product.index') }}"><i class="ion ion-android-bookmark"></i> Complaint Product</a></li>
                                <li><a href="{{ route('complaint_service.index') }}"><i class="ion ion-android-bookmark"></i> Complaint Service</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="ion ion-ribbon-a"></i> Suggestions
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>

                            <ul class="treeview-menu">
                                <li><a href="{{ route('suggestion_product.index') }}"><i class="ion ion-android-bookmark"></i> Suggestion Product</a></li>
                                <li><a href="{{ route('suggestion_service.index') }}"><i class="ion ion-android-bookmark"></i> Suggestion Service</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ route('question.index') }}"><i class="ion ion-help-circled"></i> Questions </a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#!">
                        <i class="ion ion-ios-list-outline"></i> <span>List</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>

                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href="#!">
                                <i class="ion ion-settings"></i> Complaints
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>

                            <ul class="treeview-menu">
                                <li><a href="{{ route('complaint_product_list.index') }}"><i class="ion ion-ios-list-outline"></i> List of Product Complaint</a></li>
                                <li><a href="{{ route('complaint_service_list.index') }}"><i class="ion ion-ios-list-outline"></i> List of Service Complaint</a></li>
                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#">
                                <i class="ion ion-ribbon-a"></i> Suggestions
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>

                            <ul class="treeview-menu">
                                <li><a href="{{ route('suggestion_product_list.index') }}"><i class="ion ion-ios-list-outline"></i> List of Product Suggestion</a></li>
                                <li><a href="{{ route('suggestion_service_list.index') }}"><i class="ion ion-ios-list-outline"></i> List of Service Suggestion</a></li>
                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#">
                                <i class="ion ion-help-circled"></i> Questions
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>

                            <ul class="treeview-menu">
                                <li><a href="{{ route('question_list.index') }}"><i class="ion ion-ios-list-outline"></i> List of Question</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="ion ion-soup-can"></i> <span>Master Data</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('product.index') }}"> <i class="ion ion-filing"></i> Master Product </a></li>
                        <li><a href="{{ route('service.index') }}"> <i class="ion ion-bowtie"></i> Master Service </a></li>
                        <li><a href="{{ route('tag.index') }}"> <i class="ion ion-pricetag"></i> Master Tag </a></li>
                        <li><a href="{{ route('customer.index') }}"> <i class="ion ion-ios-people"></i> Customer List </a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-pie-chart"></i>
                        <span>Report</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>

                    <ul class="treeview-menu">

                        <li>
                            <a href="{{ route('complaint_report.index') }}">
                                <i class="fa fa-bar-chart"></i>Complaint
                            </a>
                            {{--<ul class="treeview-menu">--}}
                                {{--<li><a href="#!"><i class="ion ion-paper-airplane"></i> All</a></li>--}}
                                {{--<li><a href="#!"><i class="ion ion-paper-airplane"></i> Product</a></li>--}}
                                {{--<li><a href="#!"><i class="ion ion-paper-airplane"></i> Service</a></li>--}}
                            {{--</ul>--}}
                        </li>

                        <li>
                            <a href="#!">
                                <i class="fa fa-bar-chart"></i>Suggestion
                            </a>
                            {{--<ul class="treeview-menu">--}}
                                {{--<li><a href="#!"><i class="ion ion-paper-airplane"></i> All</a></li>--}}
                                {{--<li><a href="#!"><i class="ion ion-paper-airplane"></i> Product</a></li>--}}
                                {{--<li><a href="#!"><i class="ion ion-paper-airplane"></i> Service</a></li>--}}
                            {{--</ul>--}}
                        </li>

                    </ul>
                </li>

                @if(Auth::user()->user_group->name == 'Administrator')
                    <li class="">
                        <a href="{{ route('user.index') }}">
                            <i class="fa fa-user-circle-o"></i>
                            <span>Manage Users</span>
                        </a>
                    </li>
                @endif

                <li>
                    <a href="#">
                        <i class="fa fa-calendar"></i> <span>Calendar</span>
                        <span class="pull-right-container">
                          <small class="label pull-right bg-red">3</small>
                          <small class="label pull-right bg-blue">17</small>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-envelope"></i> <span>Mailbox</span>
                        <span class="pull-right-container">
                          <small class="label pull-right bg-yellow">12</small>
                          <small class="label pull-right bg-green">16</small>
                          <small class="label pull-right bg-red">5</small>
                        </span>
                    </a>
                </li>
                {{--<li class="header">LABELS</li>--}}
                {{--<li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>--}}
                {{--<li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>--}}
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            @if(\Route::currentRouteName() == 'home')
                <h1>
                    Dashboard
                    <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            @else
                @yield('content-header')
            @endif
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            @if(\Route::currentRouteName() == 'home')
                @include('dashboard')
            @else
                @yield('main-content')
            @endif

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            <!-- Anything you want -->
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; <?php echo date("Y"); ?> <a href="#">Sunwell System</a>.</strong> All rights reserved.
    </footer>

@endsection
