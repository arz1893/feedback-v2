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
    <div class="text-center">
        @if($service->img != null)
            <img src="{{ asset($service->img) }}" width="200" class="" alt="{{ $service->name }}">
        @else
            <img src="{{ asset('default-images/no-image.jpg') }}" width="200" class="" alt="{{ $service->name }}">
        @endif
    </div>
    <div class="text-center">
        <small class="text-muted">{{ $service->name }}</small>
    </div>

    <div class="row">
        <div class="col-md-8 col-lg-offset-2">
            {{ Form::open(['method' => 'PUT', 'action' => ['MasterData\ServiceController@changePicture', $service], 'id' => 'form_change_service_picture', 'files' => true]) }}
            <div class="form-group col-lg-6 col-lg-offset-5">
                <input type="file" id="service_picture" name="service_picture" accept="image/*" onchange="$('#form_change_service_picture').submit()">
                <p class="help-block">Change your product picture</p>
            </div>
            {{ Form::close() }}
            <br>

            {{ Form::model($service, ['method' => 'PATCH', 'action' => ['MasterData\ServiceController@update', $service]]) }}
                @include('layouts.master_data.services.edit_service_form', ['submitButtonText' => 'Update Service'])
            {{ Form::close() }}
        </div>
    </div>

@endsection