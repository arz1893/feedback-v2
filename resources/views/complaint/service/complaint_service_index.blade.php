@extends('home')

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/complaint') }}"><i class="ion ion-settings"></i> Complaint selection</a></li>
        <li class="active">Complaint Service</li>
    </ol>

    <h2 class="text-center text-danger">Complaint</h2>

    <div class="centered-pills" style="margin-top: 5px;">
        <ul class="nav nav-pills">
            <li><a href="{{ route('complaint_product.index') }}">Product</a></li>
            <li role="presentation" class="active"><a data-toggle="pill" href="#service_panel">Service</a></li>
        </ul>
    </div>
@endsection

@section('main-content')
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-info btn-flat" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
    </div>
    <br>

    <div class="col-lg-11">
        <div class="tab-content">
            <div id="service_panel" class="tab-pane fade in active">
                <div class="row visible-lg visible-md visible-sm">
                    @foreach($services as $service)
                        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
                            <div class="imagebox">
                                <a href="{{ route('show_complaint_service', [$service->systemId, 0]) }}">
                                    @if($service->img == null)
                                        <img src="{{ asset('default-images/no-image.jpg') }}" class="category-banner img-responsive">
                                    @else
                                        <img src="{{ asset($service->img) }}" class="category-banner img-responsive">
                                    @endif
                                    <span class="imagebox-desc">{{ $service->name }}</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row visible-xs">
                    <div class="list-group">
                        @foreach($services as $service)
                            <a href="{{ route('show_complaint_service', [$service->systemId, 0]) }}" class="list-group-item">
                                @if($service->img != null)
                                    <img src="{{ asset($service->img) }}" style="max-width: 75px; max-height: 50px;">
                                @else
                                    <img src="{{ asset('default-images/no-image.jpg') }}" style="max-width: 75px; max-height: 50px;">
                                @endif
                                {{ $service->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="row">
                    <div class="text-center">
                        {{ $services->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection