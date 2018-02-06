@extends('home')

@push('scripts')
    <script src="{{ asset('js/vue/vue_product.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h4> Add Product </h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('product.index') }}"><i class="ion ion-filing"></i> Master Product</a></li>
        <li class="active">Add Product</li>
    </ol>
@endsection

@section('main-content')

    @include('layouts.errors.error_list')

    <div id="vue_product_container">
        {{ Form::open(['action' => 'MasterData\ProductController@store', 'files' => true, 'id' => 'form_add_product']) }}
            {{ Form::hidden('tenantId', Auth::user()->tenantId) }}
            @include('layouts.master_data.products.add_product_form')
        {{ Form::close() }}
    </div>

@endsection