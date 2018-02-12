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
                            <input type="text" class="form-control" placeholder="Search for..." v-model="searchString">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button">
                                    <i class="ion ion-search"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <div class="input-group">
                            <script type="text/x-template" id="select2-template">
                                <select>
                                    <slot></slot>
                                </select>
                            </script>
                            {{ Form::select('tags[]', $selectTags, null, ['id' => 'select_tags', 'class' => 'select2-tag', 'multiple' => true,'style' => 'width: 100%;', 'v-bind:value' => 'searchTags']) }}
                        </div><!-- /input-group -->
                    </div>
                </div>
            </div>
        </div>

        <div id="product_panel" class="col-lg-12">
            <div class="row visible-lg visible-md visible-sm">
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4" v-for="product in filteredProducts">
                    <div class="imagebox">
                        <a v-bind:href="product.show_url">
                            <img v-show="product.img !== ''" v-bind:src="product.img"  class="category-banner img-responsive">
                            <img v-show="product.img === ''" src="{{ asset('default-images/no-image.jpg') }}"  class="category-banner img-responsive">
                            <span class="imagebox-desc">
                                @{{ product.name }}
                            </span>
                        </a>
                    </div>
                    {{--<ul v-for="tag in product.productTags">--}}
                        {{--<li>@{{ tag.name }}</li>--}}
                    {{--</ul>--}}
                </div>
            </div>

            <div class="row visible-xs">
                <div class="list-group">
                    <div v-for="product in filteredProducts">
                        <a v-bind:href="product.show_url" class="list-group-item">
                            <img v-bind:src="product.img" style="width: 40px; height: 30px;">
                            @{{ product.name }}
                        </a>
                    </div>
                </div>
            </div>

            {{--@if(count($products) == 0)--}}
                {{--<div class="well">--}}
                    {{--<h4 class="text-center">Sorry you don't have any product yet</h4>--}}
                {{--</div>--}}
            {{--@endif--}}
            {{--<div class="row visible-lg visible-md visible-sm">--}}
                {{--@foreach($products as $product)--}}
                    {{--<div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">--}}
                        {{--<div class="imagebox">--}}
                            {{--<a href="{{ route('show_complaint_product', [$product->systemId, 0]) }}">--}}
                                {{--@if($product->img != null)--}}
                                    {{--<img src="{{ asset($product->img) }}"  class="category-banner img-responsive">--}}
                                {{--@else--}}
                                    {{--<img src="{{ asset('default-images/no-image.jpg') }}"  class="category-banner img-responsive">--}}
                                {{--@endif--}}
                                {{--<span class="imagebox-desc">{{ $product->name }}</span>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--@endforeach--}}
            {{--</div>--}}

            {{--<div class="row visible-xs">--}}
                {{--<div class="list-group">--}}
                    {{--@foreach($products as $product)--}}
                        {{--<a href="{{ route('show_complaint_product', [$product->systemId, 0]) }}" class="list-group-item">--}}
                            {{--@if($product->img != null)--}}
                                {{--<img src="{{ asset($product->img) }}" style="width: 40px; height: 30px;">--}}
                            {{--@else--}}
                                {{--<img src="{{ asset('default-images/no-image.jpg') }}" style="width: 40px; height: 30px;">--}}
                            {{--@endif--}}
                            {{--{{ $product->name }}--}}
                        {{--</a>--}}
                    {{--@endforeach--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="row">--}}
                {{--<div class="text-center">--}}
                    {{--{{ $products->links() }}--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>
@endsection