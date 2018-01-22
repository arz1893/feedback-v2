@extends('home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vue-animation/vue2-animate.css') }}"
          xmlns:v-on="http://www.w3.org/1999/xhtml">
@endpush

@push('scripts')
    <script src="{{ asset('js/vue/vue_product.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vue/vue_customer.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('complaint_product.index') }}"><i class="fa fa-question-circle"></i> Complaint Product </a></li>
        <li class="active">Product</li>
    </ol>

    <div class="media">
        <div class="media-left">
            <a href="#">
                <img class="media-object" src="{{ $product->img }}" alt="..." width="64" height="64">
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">{{ $product->name }}</h4>
            <small class="text-red">*Please choose category that you want to complaint</small>
        </div>
    </div>
@endsection

@section('main-content')
    {{ Form::hidden('product_id', $product->systemId, ['id' => 'product_id']) }}

    @include('layouts.errors.error_list')

    @if(\Session::has('status'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            {{ \Session::get('status') }}
        </div>
    @endif

    <div id="vue_product_container">

        <transition name="fadeDown">
            <a href="#!" class="btn btn-link btn-lg hidden" id="btn_show_category_navigator" v-on:click="showNavigator()">
                <i class="fa fa-arrow-circle-left"></i> Back
            </a>
        </transition>

        <transition name="fadeDown">
            <div id="category_navigator" v-if="show">
                <h3>Categories</h3>

                @if(isset($currentParentNode))
                    @if($currentParentNode->parent_id == null)
                        <a href="{{ route('show_complaint_product', [$product->systemId, 0]) }}" class="btn btn-link btn-lg">
                            <i class="fa fa-arrow-circle-up"></i> Up One Level
                        </a> <br>
                    @else
                        <a href="{{ route('show_complaint_product', [$product->systemId, $currentParentNode->parent_id]) }}" class="btn btn-link btn-lg">
                            <i class="fa fa-arrow-circle-up"></i> Up One Level
                        </a> <br>
                    @endif
                @endif

                @foreach($productCategories as $productCategory)
                    @if(count($productCategory->getImmediateDescendants()) > 0)
                        <a href="{{ route('show_complaint_product', [$product->systemId, $productCategory->id]) }}" class="btn btn-app bg-teal">
                            <span class="badge bg-aqua">{{ count($productCategory->getImmediateDescendants()) }}</span>
                            <i class="ion ion-pricetag" aria-hidden="true"></i> {{ $productCategory->name }}
                        </a>
                    @elseif(count($productCategory->getImmediateDescendants()) == 0)
                        <button class="btn btn-app bg-teal"
                                data-node_id="{{ $productCategory->id }}"
                                data-product_id="{{ $product->systemId }}"
                                data-title="{{ $productCategory->name }}"
                                v-on:click="append('{{ $productCategory->name }}', '{{ $product->systemId }}', '{{ $productCategory->id }}')">
                            <i class="ion ion-pricetag" aria-hidden="true"></i> {{ $productCategory->name }}
                        </button>
                    @endif
                @endforeach
            </div>
        </transition>

        <div class="row">
            <div class="col-lg-6">
                <transition name="fadeDown">
                    <div class="panel panel-danger hidden" id="panel_product">
                        <div class="panel-heading">
                            <h4>Add Complaint to : @{{ nodeTitle }}</h4>
                        </div>
                        <div class="panel-body">
                            {{ Form::open(['action' => 'Complaint\ComplaintProductController@store', 'id' => 'form_add_complaint_product']) }}
                            <div v-html="productId"></div>
                            <div v-html="productCategoryId"></div>
                            {{ Form::hidden('tenantId', Auth::user()->tenantId) }}
                                @include('layouts.complaint.product.complaint_product_form', ['submitButtonText' => 'Add Complaint', 'functionName' => 'onChangeCustomer($event)'])
                            {{ Form::close() }}
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </div>

    @include('customer.manage_customer')


    {{--<button class="btn btn-danger btn-flat" onclick="setComplaintTarget(this)">--}}
    {{--Add Complaint <i class="ion ion-plus-circled"></i>--}}
    {{--</button>--}}

    {{--<button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal_add_customer">--}}
    {{--Add User <i class="fa fa-user-plus"></i>--}}
    {{--</button>--}}

    {{--<div id="complaint_product_tree" class="fancytree-colorize-hover fancytree-fade-expander"></div>--}}

@endsection