@extends('home')

@push('scripts')
    <script src="{{ asset('js/vue/vue_service.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/faq') }}"><i class="ion ion-settings"></i> Faq selection</a></li>
        <li class="active">Faq Product</li>
    </ol>
    <span class="text-info" style="font-size: 2em; position: relative; top: 5px;">FAQ</span>
    <a href="{{ route('faq_product.index') }}" class="btn btn-sm btn-link">Product</a>
    <a href="{{ route('faq_service.index') }}" class="btn btn-sm btn-flat bg-aqua">Service</a>
@endsection

@section('main-content')
    @if(\Session::has('status'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Success!</strong> {{ \Session::get('status') }}
        </div>
    @endif

    @include('layouts.errors.error_list')

    <div id="service_index">
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
                        {{ Form::select('tags[]', $selectTags, null, ['id' => 'select_tags', 'class' => 'selectize', 'style' => '', 'multiple' => true]) }}
                        <span class="visible-md visible-sm visible-xs">
                            <span v-if="searchStatus.length > 0"><i class="fa fa-spinner fa-spin"></i> @{{ searchStatus }}</span>
                        </span>
                    </div>
                </div>
                <div class="col-lg-4 visible-lg">
                    <span v-if="searchStatus.length > 0"><i class="fa fa-spinner fa-spin"></i> @{{ searchStatus }}</span>
                </div>
            </div>
        </div>

        <div id="service_panel" class="col-lg-12">
            <div class="row visible-lg visible-md visible-sm">
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4" v-for="service in filteredServices">
                    <div class="imagebox">
                        <a v-bind:href="service.show_faq_url">
                            <img v-show="service.img !== ''" v-bind:src="service.img"  class="category-banner img-responsive">
                            <img v-show="service.img === ''" src="{{ asset('default-images/no-image.jpg') }}"  class="category-banner img-responsive">
                            <span class="imagebox-desc">
                                @{{ service.name }}
                            </span>
                        </a>
                    </div>
                    {{--<div v-for="tag in product.productTags">--}}
                    {{--<div v-bind:item="searchTags" v-bind:key="tag.systemId" v-bind:title="tag.name">@{{ tag.name }}</div>--}}
                    {{--</div>--}}
                </div>
            </div>

            <div class="row visible-xs">
                <div class="list-group">
                    <div v-for="service in filteredServices">
                        <a v-bind:href="service.show_faq_url" class="list-group-item">
                            <img v-bind:src="service.img" style="width: 40px; height: 30px;">
                            @{{ service.name }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection