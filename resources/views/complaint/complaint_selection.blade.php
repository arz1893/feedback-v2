@extends('home')

@section('content-header')
    <h1 class="text-muted">Select FAQ</h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">FAQ</li>
    </ol>
@endsection

@section('main-content')
    <div class="container col-lg-offset-3 col-md-offset-2" style="margin-top: 5%">
        <div class="row">
            <div class="col-lg-4 col-md-3 col-sm-4 col-xs-12">
                <a href="{{ route('complaint_product.index') }}">
                    <div class="info-box bg-red">
                        <span class="info-box-icon"><i class="fa fa-truck"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">FAQ Product</span>
                            {{--<span class="product-description">--}}
                            {{--{{ $productCounter }} item--}}
                            {{--</span>--}}
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </a>
            </div>
            <!-- /.col -->
            <div class="col-lg-4 col-md-3 col-sm-4 col-xs-12">
                <a href="{{ route('complaint_service.index') }}">
                    <div class="info-box bg-red">
                        <span class="info-box-icon"><i class="fa fa-trophy"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">FAQ Service</span>
                            <span class="info-box-number"></span>
                            {{--<span class="progress-description">--}}
                            {{--{{ $serviceCounter }} item--}}
                            {{--</span>--}}
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </a>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
@endsection