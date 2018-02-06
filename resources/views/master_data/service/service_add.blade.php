@extends('home')

@push('scripts')
    <script src="{{ asset('js/vue/vue_service.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h1>
        Add Service
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('service.index') }}"><i class="ion ion-bowtie"></i> Master Service</a></li>
        <li class="active">Add Service</li>
    </ol>
@endsection

@section('main-content')
    @include('layouts.errors.error_list')

    <div id="vue_service_container">
        {{ Form::open(['action' => 'MasterData\ServiceController@store', 'id' => 'form_add_service', 'files' => true]) }}
            @include('layouts.master_data.services.add_service_form', ['submitButtonText' => 'Add Service'])
        {{ Form::close() }}
    </div>
@endsection