@extends('home')

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/complaint') }}"><i class="ion ion-settings"></i> Complaint selection</a></li>
        <li class="active">Complaint Service</li>
    </ol>
    <span class="text-danger" style="font-size: 2em; position: relative; top: 5px;">Complaint</span>
    <a href="{{ route('complaint_product.index') }}" class="btn btn-sm btn-link">Product</a>
    <a href="{{ route('complaint_service.index') }}" class="btn btn-sm btn-flat bg-aqua">Service</a>
@endsection

@section('main-content')

    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                    <button class="btn btn-primary" type="button">
                        <i class="ion ion-search"></i>
                    </button>
                </span>
                    </div><!-- /input-group -->
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <div class="input-group">
                        {{ Form::select('tags[]', $selectTags, null, ['class' => 'select2-tag', 'multiple' => true,'style' => 'width: 100%;']) }}
                    </div><!-- /input-group -->
                </div>
            </div>
        </div>
    </div>

    <div id="service_panel" class="col-lg-12">
        @if(count($services) == 0)
            <div class="well">
                <h4 class="text-center">Sorry you don't have any service yet</h4>
            </div>
        @endif
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
                            <img src="{{ asset($service->img) }}" style="width: 40px; height: 30px;">
                        @else
                            <img src="{{ asset('default-images/no-image.jpg') }}" style="width: 40px; height: 30px;">
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
@endsection