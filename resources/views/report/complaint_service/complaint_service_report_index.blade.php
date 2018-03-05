@extends('home')

@section('content-header')
    <a href="{{ url('/home') }}" class="btn btn-link">
        <i class="fa fa-arrow-circle-left"></i> Back to dashboard
    </a>
@endsection

@section('main-content')
    <!-- Page Content -->
    <div class="container" style="margin-top: -1%;">

        <!-- Heading Row -->
        <div class="row">
            <!-- /.col-md-8 -->
            <div class="col-lg-6 col-md-4 col-sm-4">
                <img class="img-responsive img-rounded" src="{{ asset('default-images/37.svg') }}">
            </div>

            <div class="col-md-5 col-sm-4">
                <h4 class="text-orange">Welcome to Complaint Service Report</h4>
                <p align="justify">This is a template that is great for small businesses. It doesn't have too much fancy flare to it, but it makes a great use of the standard Bootstrap core components. Feel free to use this template for any project you want!</p>
            </div>
        </div>
        <!-- /.row -->
        <hr>
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-4">
                <h2 class="text-info">All Year <i class="fa fa-line-chart"></i></h2>
                <p>Vie statistic of complaint from past to current year</p>
                <a class="btn btn-danger" href="{{ route('service_report_all_year') }}">
                    Show <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
            <!-- /.col-md-4 -->
            <div class="col-md-4">
                <h2 class="text-info">Yearly <i class="fa fa-line-chart"></i></h2>
                <p>View statistic for complaint per month</p>
                <a class="btn btn-warning" href="{{ route('service_report_yearly') }}">Show
                    <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
            <!-- /.col-md-4 -->
            <div class="col-md-4">
                <h2 class="text-info">Monthly <i class="fa fa-line-chart"></i></h2>
                <p>View statistic for complaint per week</p>
                <a class="btn btn-success" href="#">
                    Show <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
            <!-- /.col-md-4 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
@endsection