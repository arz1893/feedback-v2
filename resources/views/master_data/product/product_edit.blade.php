@extends('home')

@section('content-header')
    {{--<h1>--}}
    {{--Edit Product--}}
    {{--</h1>--}}
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('product.index') }}"><i class="fa fa-truck"></i> Master Product</a></li>
        <li class="active">Edit Product</li>
    </ol>

@endsection

@section('main-content')

    @if(\Session::has('status'))
        <div class="alert alert-success alert-dismissible" role="alert" style="margin-top: 10px;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Success!</strong> {{ \Session::get('status') }}
        </div>
    @endif

    <div class="text-center">
        @if($product->img != null)
            <img src="{{ asset($product->img) }}" width="200" class="" alt="{{ $product->name }}">
        @else
            <img src="{{ asset('default-images/no-image.jpg') }}" width="200" class="" alt="{{ $product->name }}">
        @endif
    </div>
    <div class="text-center">
        <small class="text-muted">{{ $product->name }}</small>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            {{ Form::open(['method' => 'PUT', 'action' => ['MasterData\ProductController@changePicture', $product], 'id' => 'form_change_product_picture', 'files' => true]) }}
                <div class="form-group col-lg-6 col-lg-offset-3">
                    <input type="file" id="product_picture" name="product_picture" accept="image/*" onchange="$('#form_change_product_picture').submit()">
                    <p class="help-block">Change your product picture</p>
                </div>
            {{ Form::close() }}
            <br>

            {{ Form::model($product, ['method' => 'PATCH', 'action' => ['MasterData\ProductController@update', $product], 'id' => 'form_edit_product']) }}
                @include('layouts.master_data.products.edit_product_form')
            {{ Form::close() }}
        </div>
    </div>
@endsection