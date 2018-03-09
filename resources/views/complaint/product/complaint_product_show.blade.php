@extends('home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vue-animation/vue2-animate.css') }}"
          xmlns:v-on="http://www.w3.org/1999/xhtml">
@endpush

@push('scripts')
    <script src="{{ asset('js/vue/vue_product.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vue/vue_customer.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/tree-crud/tree-product-function.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <div class="media">
        <div class="media-left">
            <a href="#">
                @if($product->img != null)
                    <img class="media-object" src="{{ asset($product->img) }}" alt="..." width="64" height="64">
                @else
                    <img class="media-object" src="{{ asset('default-images/no-image.jpg') }}" alt="..." width="64" height="64">
                @endif
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">{{ $product->name }}</h4>
            @if(count($product->tags) > 0)
                @foreach($product->tags as $tag)
                    <span class="label" style="background: {{ $tag->bgColor }}">{{ $tag->name }}</span>
                @endforeach
            @endif
            <br>
            <small class="text-red">*Please choose category that you want to complaint</small>
        </div>
    </div>

    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('complaint_product.index') }}"><i class="fa ion-settings"></i> Complaint Product </a></li>
        <li class="active">Add Complaint</li>
    </ol>
@endsection

@section('main-content')
    {{ Form::hidden('product_id', $product->systemId, ['id' => 'product_id']) }}

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_category">
        <i class="fa fa-plus"></i> Add Category
    </button> <br>

    @include('layouts.errors.error_list')

    @if(\Session::has('status'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            {{ \Session::get('status') }}
        </div>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="modal_category" tabindex="-1" role="dialog" aria-labelledby="modal_category_label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal_category_label">Add Category</h4>
                </div>
                <div class="modal-body">
                    {{ Form::hidden('product_id', $product->systemId, ['id' => 'product_id']) }}

                    <!-- Nav tabs -->
                    <ul class="nav nav-pills" role="tablist">
                        <li role="presentation" class="active"><a href="#add-root" aria-controls="home" role="tab" data-toggle="tab">Add Category</a></li>
                        <li role="presentation"><a href="#add-sub" aria-controls="profile" role="tab" data-toggle="tab">Add Sub Category</a></li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="add-root">
                            <div class="">
                                <div class="input-group">
                                    <input name="category_name" id="category_name" type="text" class="form-control" placeholder="Enter category name...">
                                    <span class="input-group-btn">
                                    <button class="btn btn-info"
                                            type="button"
                                            data-product_id="{{ $product->systemId }}"
                                            data-type="root" onclick="setProductCategoryType(this)">
                                        Add
                                    </button>
                                </span>
                                </div>
                                <p id="category_name_error" class="help-block text-red invisible">please enter category name</p>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="add-sub">
                            <div class="input-group">
                                <input name="sub_name" id="sub_name" type="text" class="form-control" placeholder="Enter sub category name...">
                                <span class="input-group-btn">
                                    <button class="btn btn-warning"
                                            type="button"
                                            data-product_id="{{ $product->systemId }}"
                                            data-type="sub" onclick="setProductCategoryType(this)">
                                        Add
                                    </button>
                                </span>
                            </div>
                            <p id="sub_category_error" class="help-block text-red invisible">please enter sub category name</p>
                        </div>
                    </div>

                    <div id="product_tree"></div>

                    <button type="button"
                            class="btn btn-sm btn-warning"
                            data-product-id="{{ $product->systemId }}"
                            data-type="edit"
                            onclick="setProductCategoryType(this)">
                        <i class="ion ion-edit" aria-hidden="true"></i> Rename
                    </button>
                    <button type="button"
                            class="btn btn-sm btn-danger"
                            data-product-id="{{ $product->systemId }}"
                            data-type="delete"
                            onclick="setProductCategoryType(this)">
                        <i class="ion ion-close-circled" aria-hidden="true"></i> Remove
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <div id="vue_product_container">

        <transition name="fadeDown">
            <a href="#!" class="btn btn-link btn-lg hidden" id="btn_show_category_navigator" v-on:click="showNavigator()">
                <i class="fa fa-arrow-circle-left"></i> Back
            </a>
        </transition>

        <transition name="fadeDown">
            <div id="category_navigator" v-if="show">

                <h3> Categories </h3>

                @if(count($productCategories) == 0)
                    <span class="text-danger">Sorry you haven't add some category to this product, please add it first on master data</span>
                @endif

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
                        <a href="{{ route('show_complaint_product', [$product->systemId, $productCategory->id]) }}" class="btn btn-lg btn-info btn3d">
                            <i class="ion ion-navigate" aria-hidden="true"></i> {{ $productCategory->name }}
                            <span class="badge bg-teal">{{ count($productCategory->getImmediateDescendants()) }}</span>
                        </a>
                    @elseif(count($productCategory->getImmediateDescendants()) == 0)
                        <button class="btn btn-lg btn-info btn3d"
                                data-node_id="{{ $productCategory->id }}"
                                data-product_id="{{ $product->systemId }}"
                                data-title="{{ $productCategory->name }}"
                                v-on:click="append('{{ $productCategory->name }}', '{{ $product->systemId }}', '{{ $productCategory->id }}')">
                            <i class="ion ion-navigate" aria-hidden="true"></i> {{ $productCategory->name }}
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
                            {{ Form::open(['action' => 'Complaint\ComplaintProductController@store', 'files' => true, 'id' => 'form_add_complaint_product']) }}
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