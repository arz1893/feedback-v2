@extends('home')

@section('content-header')
    <a href="{{ url('/complaint') }}" class="btn btn-link">
        <i class="fa fa-arrow-circle-left"></i> Back
    </a>

    <h2 class="text-center text-danger" style="margin-top: -33px;">Complaint</h2>

    <div class="centered-pills" style="margin-top: 5px;">
        <ul class="nav nav-pills">
            <li><a href="{{ route('complaint_product.index') }}">Product</a></li>
            <li role="presentation" class="active"><a data-toggle="pill" href="#service_panel">Service</a></li>
        </ul>
    </div>
@endsection

@section('main-content')
    <div class="row">
        <div class="col-lg-12">
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

    <div class="tab-content">
        <div id="service_panel" class="tab-pane fade in active">
            <div class="row">
                @foreach($services as $service)
                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                        <div class="imagebox">
                            <a href="{{ route('show_complaint_service', [$service->systemId, 0]) }}">
                                @if($service->img == null)
                                    <img src="{{ asset('default_images/handshake.jpg') }}" class="category-banner img-responsive">
                                @else
                                    <img src="{{ asset($service->img) }}" class="category-banner img-responsive">
                                @endif
                                <span class="imagebox-desc">{{ $service->name }}</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="text-center">
                    {{ $services->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection