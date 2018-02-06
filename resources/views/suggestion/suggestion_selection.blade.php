@extends('home')

@section('content-header')
    <h1 class="text-muted">Select Suggestion</h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Suggestion</li>
    </ol>
@endsection

@section('main-content')
    <div style="margin-top: 2%">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <a href="{{ route('suggestion_product.index') }}">
                    <div class="info-box bg-orange">
                        <span class="info-box-icon"><i class="ion ion-filing"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Suggestion Product</span>

                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description" style="font-size: 0.8em;">
                            Add suggestion to product
                        </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </a>
            </div>
            <!-- /.col -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <a href="{{ route('suggestion_service.index') }}">
                    <div class="info-box bg-orange">
                        <span class="info-box-icon"><i class="ion ion-bowtie"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Suggestion Service</span>

                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description" style="font-size: 0.8em;">
                            Add suggestion to service
                        </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </a>
            </div>
            <!-- /.col -->
        </div>
    </div>
@endsection