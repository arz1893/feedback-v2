@extends('home')

@section('content-header')
    <a href="{{ url('/home') }}" class="btn btn-link">
        <i class="fa fa-arrow-circle-left"></i> Back to dashboard
    </a>
@endsection

@section('main-content')
    <div class="container">

        <!-- Heading Row -->
        <div class="row">

            <div class="col-lg-6 col-md-4 col-sm-4">
                <img class="img-responsive img-rounded" src="{{ asset('default-images/37.svg') }}">
            </div>

            <div class="col-md-5 col-sm-4">
                <h4 class="text-yellow">Welcome to Suggestion Report Section</h4>
                <p align="justify">This is a template that is great for small businesses. It doesn't have too much fancy flare to it, but it makes a great use of the standard Bootstrap core components. Feel free to use this template for any project you want!</p>
            </div>
            <!-- /.col-md-4 -->
        </div>
        <!-- /.row -->
        <hr>
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-4">
                <h2 class="text-info">All Suggestion <i class="fa fa-line-chart"></i></h2>
                <p>Contains all product and service report</p>
                <a class="btn btn-danger" role="button">
                    Show <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
            <!-- /.col-md-4 -->
            <div class="col-md-4">
                <h2 class="text-info">Product <i class="fa fa-line-chart"></i></h2>
                <p>View all suggestion product report</p>
                <a class="btn btn-warning" href="{{ route('suggestion_product_report.index') }}" role="button">Show
                    <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
            <!-- /.col-md-4 -->
            <div class="col-md-4">
                <h2 class="text-info">Service <i class="fa fa-line-chart"></i></h2>
                <p>View all suggestion service report</p>
                <a class="btn btn-success" role="button">
                    Show <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
            <!-- /.col-md-4 -->
        </div>
        <!-- /.row -->

    </div>
@endsection