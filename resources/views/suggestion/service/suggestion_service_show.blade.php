@extends('home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vue-animation/vue2-animate.css') }}" xmlns:v-on="http://www.w3.org/1999/xhtml">
@endpush

@push('scripts')
    <script src="{{ asset('js/vue/vue_suggestion_service.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('suggestion_service.index') }}"><i class="fa fa-question-circle"></i> Suggestion Service </a></li>
        <li class="active">Service</li>
    </ol>

    <div class="media">
        <div class="media-left">
            <a href="#">
                <img class="media-object" src="{{ $service->img }}" alt="..." width="64" height="64">
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

    <div id="vue_suggestion_service_container">

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
                        <a href="{{ route('show_suggestion_service', [$service->systemId, $serviceCategory->id]) }}" class="btn btn-app">
                            <span class="badge bg-aqua">{{ count($serviceCategory->getImmediateDescendants()) }}</span>
                            <i class="ion ion-pricetag" aria-hidden="true"></i> {{ $serviceCategory->name }}
                        </a>
                    @elseif(count($serviceCategory->getImmediateDescendants()) == 0)
                        <button class="btn btn-app active"
                                data-node_id="{{ $serviceCategory->id }}"
                                data-service_id="{{ $service->systemId }}"
                                data-title="{{ $serviceCategory->name }}"
                                v-on:click="append('{{ $serviceCategory->name }}', '{{ $service->systemId }}', '{{ $serviceCategory->id }}')">
                            <i class="ion ion-pricetag" aria-hidden="true"></i> {{ $serviceCategory->name }}
                        </button>
                    @endif
                @endforeach
            </div>
        </transition>

        @include('layouts.errors.error_list')

        <div class="row">
            <div class="col-lg-6">
                <transition name="fadeDown">
                    <div class="panel panel-warning hidden" id="panel_add_suggestion_service">
                        <div class="panel-heading">
                            <div v-html="nodeTitle"></div>
                        </div>
                        <div class="panel-body">
                            {{ Form::open(['action' => 'Suggestion\SuggestionServiceController@store', 'id' => 'form_add_suggestion_service']) }}
                            <div v-html="serviceId"></div>
                            <div v-html="serviceCategoryId"></div>
                            {{ Form::hidden('tenantId', Auth::user()->tenantId) }}
                            @include('layouts.suggestion.service.suggestion_service_form', ['submitButtonText' => 'Add Suggestion'])
                            {{ Form::close() }}
                        </div>
                    </div>
                </transition>
            </div>
        </div>

    </div>

    @include('customer.modal_add_customer')

    {{--<button class="btn btn-danger btn-flat" onclick="setComplaintTarget(this)">--}}
    {{--Add Complaint <i class="ion ion-plus-circled"></i>--}}
    {{--</button>--}}

    {{--<button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal_add_customer">--}}
    {{--Add User <i class="fa fa-user-plus"></i>--}}
    {{--</button>--}}

    {{--<div id="complaint_product_tree" class="fancytree-colorize-hover fancytree-fade-expander"></div>--}}

@endsection