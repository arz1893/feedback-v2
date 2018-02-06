@extends('home')

@section('content-header')

    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/faq') }}"><i class="fa fa-question-circle"></i> FAQ selection</a></li>
        <li class="active">FAQ Product</li>
    </ol>

    <h2 class="text-center text-light-blue">FAQ</h2>

    <div class="centered-pills" style="margin-top: 5px;">
        <ul class="nav nav-pills">
            <li role="presentation" class="active"><a data-toggle="pill" href="#product_panel">Product</a></li>
            <li><a href="{{ route('faq_service.index') }}">Service</a></li>
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
            <div id="product_panel" class="tab-pane fade in active">
                <div class="row visible-lg visible-md visible-sm">
                    @foreach($products as $product)
                        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
                            <div class="imagebox">
                                <a href="{{ route('faq_product.show', $product->systemId) }}">
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
                            <a href="{{ route('faq_product.show', $product->systemId) }}" class="list-group-item">
                                @if($product->img != null)
                                    <img src="{{ asset($product->img) }}" style="max-width: 75px; max-height: 50px;">
                                @else
                                    <img src="{{ asset('default-images/no-image.jpg') }}" style="max-width: 75px; max-height: 50px;">
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
    </div>
@endsection