@extends('home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vue-animation/vue2-animate.css') }}" xmlns:v-on="http://www.w3.org/1999/xhtml">
@endpush

@push('scripts')
    <script src="{{ asset('js/vue/vue_service.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vue/vue_customer.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/tree-crud/tree-service-function.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('suggestion_service.index') }}"><i class="ion ion-ribbon-a"></i> Suggestion Service </a></li>
        <li class="active">Add Suggestion</li>
    </ol>

    <div class="media">
        <div class="media-left">
            <a href="#">
                @if($service->img != null)
                    <img class="media-object" src="{{ asset($service->img) }}" alt="..." width="64" height="64">
                @else
                    <img class="media-object" src="{{ asset('default-images/no-image.jpg') }}" alt="..." width="64" height="64">
                @endif
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">{{ $service->name }}</h4>
            <small class="text-orange">*Please choose category that you want to suggest</small>
        </div>
    </div>
@endsection

@section('main-content')
    {{ Form::hidden('service_id', $service->systemId, ['id' => 'service_id']) }}

    @if(\Session::has('status'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            {{ \Session::get('status') }}
        </div>
    @endif

    @include('layouts.errors.error_list')

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_category">
        <i class="fa fa-plus"></i> Add Category
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modal_category" tabindex="-1" role="dialog" aria-labelledby="modal_category_label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal_category_label">Add Category</h4>
                </div>
                <div class="modal-body">
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
                                            data-service_id="{{ $service->systemId }}"
                                            data-type="root" onclick="setServiceCategoryType(this)">
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
                                            data-service_id="{{ $service->systemId }}"
                                            data-type="sub" onclick="setServiceCategoryType(this)">
                                        Add
                                    </button>
                                </span>
                            </div>
                            <p id="sub_category_error" class="help-block text-red invisible">please enter sub category name</p>
                        </div>
                    </div>

                    <div id="service_tree"></div>

                    <button type="button"
                            class="btn btn-sm btn-warning"
                            data-service-id="{{ $service->systemId }}"
                            data-type="edit"
                            onclick="setServiceCategoryType(this)">
                        <i class="ion ion-edit" aria-hidden="true"></i> Rename
                    </button>
                    <button type="button"
                            class="btn btn-sm btn-danger"
                            data-service-id="{{ $service->systemId }}"
                            data-type="delete"
                            onclick="setServiceCategoryType(this)">
                        <i class="ion ion-close-circled" aria-hidden="true"></i> Remove
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div id="vue_service_container">

        <transition name="fadeDown">
            <a href="#!" class="btn btn-link btn-lg hidden" id="btn_show_category_navigator" v-on:click="showNavigator()">
                <i class="fa fa-arrow-circle-left"></i> Back
            </a>
        </transition>

        <transition name="fadeDown">
            <div id="category_navigator" v-if="show">
                <h3>Categories</h3>
                @if(count($serviceCategories) == 0)
                    <span class="text-danger">Sorry you haven't add some category to this service, please add it first on master data</span>
                @endif
                @if(isset($currentParentNode))
                    @if($currentParentNode->parent_id == null)
                        <a href="{{ route('show_suggestion_service', [$service->systemId, 0]) }}" class="btn btn-link btn-lg">
                            <i class="fa fa-arrow-circle-up"></i> Up One Level
                        </a> <br>
                    @else
                        <a href="{{ route('show_suggestion_service', [$service->systemId, $currentParentNode->parent_id]) }}" class="btn btn-link btn-lg">
                            <i class="fa fa-arrow-circle-up"></i> Up One Level
                        </a> <br>
                    @endif
                @endif

                @foreach($serviceCategories as $serviceCategory)
                    @if(count($serviceCategory->getImmediateDescendants()) > 0)
                        <a href="{{ route('show_suggestion_service', [$service->systemId, $serviceCategory->id]) }}" class="btn btn-lg btn-info btn3d">
                            <span class="badge bg-aqua">{{ count($serviceCategory->getImmediateDescendants()) }}</span>
                            <i class="ion ion-navigate" aria-hidden="true"></i> {{ $serviceCategory->name }}
                        </a>
                    @elseif(count($serviceCategory->getImmediateDescendants()) == 0)
                        <button class="btn btn-lg btn-info btn3d"
                                data-node_id="{{ $serviceCategory->id }}"
                                data-service_id="{{ $service->systemId }}"
                                data-title="{{ $serviceCategory->name }}"
                                v-on:click="append('{{ $serviceCategory->name }}', '{{ $service->systemId }}', '{{ $serviceCategory->id }}')">
                            <i class="ion ion-navigate" aria-hidden="true"></i> {{ $serviceCategory->name }}
                        </button>
                    @endif
                @endforeach
            </div>
        </transition>

        <div class="row">
            <div class="col-lg-6">
                <transition name="fadeDown">
                    <div class="panel panel-warning hidden" id="panel_service">
                        <div class="panel-heading">
                            <div v-html="nodeTitle"></div>
                        </div>
                        <div class="panel-body">
                            {{ Form::open(['action' => 'Suggestion\SuggestionServiceController@store', 'id' => 'form_add_suggestion_service', 'files' => true]) }}
                            <div v-html="serviceId"></div>
                            <div v-html="serviceCategoryId"></div>
                            {{ Form::hidden('tenantId', Auth::user()->tenantId) }}
                            @include('layouts.suggestion.service.suggestion_service_form', ['submitButtonText' => 'Add Suggestion', 'functionName' => 'onChangeCustomer($event)'])
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