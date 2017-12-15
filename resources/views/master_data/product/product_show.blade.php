@extends('home')
@push('styles')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.2.3/jquery.contextMenu.min.css" />
@endpush

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.2.3/jquery.contextMenu.min.js"></script>
    <script src="{{ asset('js/tree-crud/tree-crud-product-function.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    {{--<h1 class="text-muted">Product Detail</h1>--}}
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('product.index') }}"><i class="fa fa-truck"></i> Master Product</a></li>
        <li class="active">{{ $product->name }}</li>
    </ol>

@endsection

@section('main-content')

    <div class="row">
        {{ Form::hidden('product_id', $product->systemId, ['id' => 'product_id']) }}
    </div>

    <div class="span8">
        <div class="text-center">
            <img src="{{ asset($product->img) }}" width="200" class="" alt="{{ $product->name }}">
            <h1 class="text-center">{{ $product->name }}</h1>
            @include('layouts.errors.error_list')
            @if(\Session::has('status'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Info!</strong> {{ \Session::get('status') }}
                </div>
            @endif
        </div>
        <p class="text-justify">
            <b>Description :</b> <br>
            {{ $product->description }}
        </p>
        <p class="text-justify">
            <b>Category list :</b> <br>
            @if($hasCategory == true)
                <small class="text-muted">*please select category first</small>
            @else
                <small class="text-muted">*please add category first</small>
            @endif
            <br>
        </p>
        <button type="button"
                class="btn btn-success"
                data-toggle="modal"
                data-target="#modal_add_product_category"
                data-product_id="{{ $product->systemId }}"
                data-type="root"
                onclick="setProductCategoryType(this)">
            <i class="ion ion-plus-circled"></i> Add Category
        </button>
        <button type="button"
                class="btn btn-primary"
                data-product_id="{{ $product->systemId }}"
                data-type="sub"
                onclick="setProductCategoryType(this)">
            <i class="ion ion-network" aria-hidden="true"></i> Add sub category
        </button>

        <div id="product_category_tree" class="fancytree-colorize-hover fancytree-fade-expander"></div>

        <button type="button"
                class="btn btn-warning"
                data-product-id="{{ $product->systemId }}"
                data-type="edit"
                onclick="setProductCategoryType(this)">
            <i class="ion ion-edit" aria-hidden="true"></i> Rename
        </button>
        <button type="button"
                class="btn btn-danger"
                data-product-id="{{ $product->systemId }}"
                data-type="delete"
                onclick="setProductCategoryType(this)">
            <i class="ion ion-close-circled" aria-hidden="true"></i> Remove
        </button>

        @if($hasCategory == true)
            <div id="selected-action">Click right mouse button on a node.</div>
        @endif
    </div>

    @include('layouts.master_data.product_category.modal_crud_product_category')

    <hr>

    <div class="row">
        <div class="col-sm-6">
            <div class="rating-block">
                <h4>Average user rating</h4>
                <h2 class="bold padding-bottom-7">4.3 <small>/ 5</small></h2>
                <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button>
                <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button>
                <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button>
                <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button>
                <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                </button>
            </div>
        </div>
        <div class="col-sm-3">
            <h4>Rating breakdown</h4>
            <div class="pull-left">
                <div class="pull-left" style="width:35px; line-height:1;">
                    <div style="height:9px; margin:5px 0;">5 <span class="glyphicon glyphicon-star"></span></div>
                </div>
                <div class="pull-left" style="width:180px;">
                    <div class="progress" style="height:9px; margin:8px 0;">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: 1000%">
                            <span class="sr-only">80% Complete (danger)</span>
                        </div>
                    </div>
                </div>
                <div class="pull-right" style="margin-left:10px;">1</div>
            </div>
            <div class="pull-left">
                <div class="pull-left" style="width:35px; line-height:1;">
                    <div style="height:9px; margin:5px 0;">4 <span class="glyphicon glyphicon-star"></span></div>
                </div>
                <div class="pull-left" style="width:180px;">
                    <div class="progress" style="height:9px; margin:8px 0;">
                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="5" style="width: 80%">
                            <span class="sr-only">80% Complete (danger)</span>
                        </div>
                    </div>
                </div>
                <div class="pull-right" style="margin-left:10px;">1</div>
            </div>
            <div class="pull-left">
                <div class="pull-left" style="width:35px; line-height:1;">
                    <div style="height:9px; margin:5px 0;">3 <span class="glyphicon glyphicon-star"></span></div>
                </div>
                <div class="pull-left" style="width:180px;">
                    <div class="progress" style="height:9px; margin:8px 0;">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="3" aria-valuemin="0" aria-valuemax="5" style="width: 60%">
                            <span class="sr-only">80% Complete (danger)</span>
                        </div>
                    </div>
                </div>
                <div class="pull-right" style="margin-left:10px;">0</div>
            </div>
            <div class="pull-left">
                <div class="pull-left" style="width:35px; line-height:1;">
                    <div style="height:9px; margin:5px 0;">2 <span class="glyphicon glyphicon-star"></span></div>
                </div>
                <div class="pull-left" style="width:180px;">
                    <div class="progress" style="height:9px; margin:8px 0;">
                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="5" style="width: 40%">
                            <span class="sr-only">80% Complete (danger)</span>
                        </div>
                    </div>
                </div>
                <div class="pull-right" style="margin-left:10px;">0</div>
            </div>
            <div class="pull-left">
                <div class="pull-left" style="width:35px; line-height:1;">
                    <div style="height:9px; margin:5px 0;">1 <span class="glyphicon glyphicon-star"></span></div>
                </div>
                <div class="pull-left" style="width:180px;">
                    <div class="progress" style="height:9px; margin:8px 0;">
                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="5" style="width: 20%">
                            <span class="sr-only">80% Complete (danger)</span>
                        </div>
                    </div>
                </div>
                <div class="pull-right" style="margin-left:10px;">0</div>
            </div>
        </div>
    </div>
    <br><br>

    <div class="row">
        <ul class="nav nav-tabs">
            <li role="presentation"><a href="#">FAQ</a></li>
            <li role="presentation"><a data-toggle="tab" href="#complaints_tab">Complaints</a></li>
            <li role="presentation" class="active"><a data-toggle="tab" href="#suggestions_tab">Suggestions</a></li>
        </ul>

        <div class="tab-content">
            <div id="suggestions_tab" class="tab-pane fade in active">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="review-block">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img src="http://dummyimage.com/60x60/666/ffffff&text=No+Image" class="img-rounded">
                                    <div class="review-block-name"><a href="#">nktailor</a></div>
                                    <div class="review-block-date">January 29, 2016<br/>1 day ago</div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="review-block-rate">
                                        <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                        </button>
                                        <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                        </button>
                                        <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                        </button>
                                        <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
                                            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                        </button>
                                        <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
                                            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                    <div class="review-block-title">this was nice in buy</div>
                                    <div class="review-block-description">this was nice in buy. this was nice in buy. this was nice in buy. this was nice in buy this was nice in buy this was nice in buy this was nice in buy this was nice in buy</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="complaints_tab" class="tab-pane fade in">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="review-block">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img src="http://dummyimage.com/60x60/666/ffffff&text=No+Image" class="img-rounded">
                                    <div class="review-block-name"><a href="#">Anonymous</a></div>
                                    <div class="review-block-date">January 29, 2016<br/>1 day ago</div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="review-block-rate">
                                        <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                        </button>
                                        <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
                                            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                        </button>
                                        <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
                                            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                        </button>
                                        <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
                                            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                        </button>
                                        <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
                                            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                    <div class="review-block-title text-danger">Poor service </div>
                                    <div class="review-block-description">
                                        hope it wont't happen again when i came
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection