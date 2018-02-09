@extends('home')

@push('scripts')
    <script src="{{ asset('js/vue/vue_product.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/complaint') }}"><i class="ion ion-settings"></i> Complaint selection</a></li>
        <li class="active">Complaint Product</li>
    </ol>
    <span class="text-danger" style="font-size: 2em; position: relative; top: 5px;">Complaint</span>
    <a href="{{ route('complaint_product.index') }}" class="btn btn-sm btn-flat bg-aqua">Product</a>
    <a href="{{ route('complaint_service.index') }}" class="btn btn-sm btn-link">Service</a>
@endsection

@section('main-content')
    <div id="complaint_product_index">
        {{ Form::hidden('tenantId', Auth::user()->tenantId, ['id' => 'tenantId']) }}
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

        <div id="product_panel" class="col-lg-12">
            @if(count($products) == 0)
                <div class="well">
                    <h4 class="text-center">Sorry you don't have any service yet</h4>
                </div>
            @endif
            <div class="row visible-lg visible-md visible-sm">
                @foreach($products as $product)
                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
                        <div class="imagebox">
                            <a href="{{ route('show_complaint_product', [$product->systemId, 0]) }}">
                                @if($product->img != null)
                                    <img src="{{ asset($product->img) }}"  class="category-banner img-responsive">
                                @else
                                    <img src="{{ asset('default-images/no-image.jpg') }}"  class="category-banner img-responsive">
                                @endif
                                <span class="imagebox-desc">{{ $product->name }}</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row visible-xs">
                <div class="list-group">
                    @foreach($products as $product)
                        <a href="{{ route('show_complaint_product', [$product->systemId, 0]) }}" class="list-group-item">
                            @if($product->img != null)
                                <img src="{{ asset($product->img) }}" style="width: 40px; height: 30px;">
                            @else
                                <img src="{{ asset('default-images/no-image.jpg') }}" style="width: 40px; height: 30px;">
                            @endif
                            {{ $product->name }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="text-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection