@extends('home')

@section('content-header')
    <h1>
        Add Service
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('service.index') }}"><i class="fa fa-hourglass-half"></i> Master Service</a></li>
        <li class="active">Add Service</li>
    </ol>
@endsection

@section('main-content')
    @include('layouts.errors.error_list')

    {{ Form::open(['action' => 'MasterData\ServiceController@store', 'id' => 'form_add_service', 'files' => true]) }}
        @include('layouts.master_data.services.add_service_form', ['submitButtonText' => 'Add Service'])
    {{ Form::close() }}
@endsection