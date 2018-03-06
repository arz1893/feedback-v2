@extends('home')

@section('content-header')
    <h1>
        Edit Service
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('service.index') }}"><i class="fa fa-hourglass-half"></i> Master Service</a></li>
        <li class="active">Edit Service</li>
    </ol>
@endsection

@section('main-content')

    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-3 col-xs-offset-2">
                <div class="imagebox" style="width: 225px;">
                    <a role="button" onclick="$('#service_picture').trigger('click');">
                        @if($service->img != null)
                            <img src="{{ asset($service->img) }}" width="200" class="" alt="{{ $service->name }}">
                        @else
                            <img src="{{ asset('default-images/no-image.jpg') }}" width="200" class="" alt="{{ $service->name }}">
                        @endif
                        <span class="imagebox-desc">
                            click to change picture <i class="fa fa-pencil"></i>
                        </span>
                    </a>
                </div>
            </div>

            {{ Form::open(['method' => 'PUT', 'action' => ['MasterData\ServiceController@changePicture', $service], 'id' => 'form_change_service_picture', 'files' => true]) }}
                <input type="file" id="service_picture" name="service_picture" accept="image/*" style="display: none;" onchange="$('#form_change_service_picture').submit()">
            {{ Form::close() }}

            {{ Form::model($service, ['method' => 'PATCH', 'action' => ['MasterData\ServiceController@update', $service]]) }}
                @include('layouts.master_data.services.edit_service_form', ['submitButtonText' => 'Update Service'])
            {{ Form::close() }}
        </div>
    </div>

@endsection