@extends('home')

@section('content-header')
    <h4> Add Product </h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('product.index') }}"><i class="fa fa-database"></i> Master Product</a></li>
        <li class="active">Add Product</li>
    </ol>
@endsection

@section('main-content')

    @include('layouts.errors.error_list')

    <div>
        {{ Form::open(['action' => 'MasterData\ProductController@store', 'files' => true, 'id' => 'form_add_product']) }}
            {{ Form::hidden('tenantId', Auth::user()->tenantId) }}
            @include('layouts.master_data.products.add_product_form')
        {{ Form::close() }}
    </div>

@endsection