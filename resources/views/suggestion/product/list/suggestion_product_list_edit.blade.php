@push('scripts')
    <script src="{{ asset('js/vue/vue_customer.js') }}" type="text/javascript"></script>
@endpush

@extends('home')

@section('content-header')
    <h4>Edit Suggestion Product</h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('suggestion_product_list.index') }}"><i class="ion ion-clipboard"></i>Suggestion Product List</a></li>
        <li class="active">Edit Suggestion Product</li>
    </ol>
@endsection

@section('main-content')
    <div class="col-lg-6 col-lg-offset-3">
        {{ Form::model($suggestionProduct, ['method' => 'PATCH', 'action' => ['Suggestion\SuggestionProductListController@update', $suggestionProduct], 'id' => 'form_edit_suggestion_product']) }}
            @include('layouts.suggestion.product.suggestion_product_form', ['submitButtonText' => 'Update Suggestion Product'])
        {{ Form::close() }}
    </div>

    @include('customer.manage_customer')
@endsection
