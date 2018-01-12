@extends('home')

@section('content-header')

    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/faq') }}"><i class="fa fa-question-circle"></i> FAQ Select</a></li>
        <li><a href="{{ route('faq_service.index') }}"><i class="fa fa-truck"></i> FAQ Service</a></li>
        <li class="active">Service</li>
    </ol>
    <div class="media">
        <div class="media-left">
            <a href="#">
                <img class="media-object" src="{{ $service->img }}" alt="..." width="100" height="64">
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">{{ $service->name }}</h4>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_add_service_faq">
                Add FAQ <i class="fa fa-plus-circle"></i>
            </button>
        </div>
    </div>

@endsection

@section('main-content')

    @if(\Session::has('status'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Success!</strong> {{ \Session::get('status') }}
        </div>
    @endif

    @include('layouts.errors.error_list')

    <div class="row">
        @php $counter = 1; @endphp
        @foreach($faqServices as $faqService)
            <div id="faq" class="col-lg-7">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapse-{{ $counter }}">
                                    {{ $faqService->question }}
                                </a>
                                <span class="pull-right accordion-toggle" data-toggle="collapse">
                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                            </span>
                            </h4>
                        </div>
                        <div id="collapse-{{ $counter }}" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p>
                                    {{ $faqService->answer }}
                                </p>
                            </div>
                            <div class="panel-footer">
                                @if(Auth::user()->user_group->name ==  'Administrator')
                                    <div class="">
                                        <a class="btn btn-warning btn-sm" href="{{ route('faq_service.edit', $faqService->systemId) }}" style="margin-right: 3px;">
                                            <i class="fa fa-pencil-square-o"></i> Edit
                                        </a>
                                        <button class="btn btn-danger btn-sm"
                                                data-id="{{ $faqService->systemId }}"
                                                data-type="faq_service"
                                                onclick="deleteItem(this)">
                                            <i class="fa fa-trash-o"></i> Delete
                                        </button>
                                    </div>
                                @else
                                    <div class="btn-group btn-group-xs">
                                <span class="btn">
                                    Was this question useful?
                                </span>
                                        <a class="btn btn-success" href="#"><i class="fa fa-thumbs-up"></i> Yes</a>
                                        <a class="btn btn-danger" href="#"><i class="fa fa-thumbs-down"></i> No</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @php $counter++; @endphp
        @endforeach
    </div>

    @include('layouts.faq.modal_crud_faq_service')
@endsection