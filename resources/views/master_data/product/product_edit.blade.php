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


    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-3 col-xs-offset-2">
                <div class="imagebox" style="width: 225px;">
                    <a role="button" onclick="$('#product_picture').trigger('click');">
                        @if($product->img != null)
                            <img src="{{ asset($product->img) }}" class="" alt="{{ $product->name }}">
                        @else
                            <img src="{{ asset('default-images/no-image.jpg') }}" class="" alt="{{ $product->name }}">
                        @endif
                        <span class="imagebox-desc">
                            click to change picture <i class="fa fa-pencil"></i>
                        </span>
                    </a>
                </div>
            </div>

            {{ Form::open(['method' => 'PUT', 'action' => ['MasterData\ProductController@changePicture', $product], 'id' => 'form_change_product_picture', 'files' => true]) }}
                <input type="file" id="product_picture" name="product_picture" style="display: none;" accept="image/*" onchange="$('#form_change_product_picture').submit()">
            {{ Form::close() }}

            {{ Form::model($product, ['method' => 'PATCH', 'action' => ['MasterData\ProductController@update', $product], 'id' => 'form_edit_product']) }}
                @include('layouts.master_data.products.edit_product_form')
            {{ Form::close() }}
        </div>
    </div>
@endsection