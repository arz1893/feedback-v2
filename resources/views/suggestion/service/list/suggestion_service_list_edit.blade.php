@push('scripts')
    <script src="{{ asset('js/vue/vue_customer.js') }}" type="text/javascript"></script>
@endpush

@extends('home')

@section('content-header')
    <h4>Edit Suggestion Product</h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('suggestion_service_list.index') }}"><i class="ion ion-clipboard"></i>Suggestion Service List</a></li>
        <li class="active">Edit Suggestion Service</li>
    </ol>
@endsection

@section('main-content')
    <div class="col-lg-6">
        {{ Form::model($suggestionService, ['method' => 'PATCH', 'action' => ['Suggestion\SuggestionServiceListController@update', $suggestionService], 'id' => 'form_edit_suggestion_service', 'files' => true]) }}
            @include('layouts.suggestion.service.suggestion_service_form', ['submitButtonText' => 'Update Suggestion Service'])
        {{ Form::close() }}
    </div>

    @include('customer.manage_customer')
@endsection
