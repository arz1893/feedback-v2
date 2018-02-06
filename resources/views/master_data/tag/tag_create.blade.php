@extends('home')

@section('content-header')
    <h4> Add Tag </h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('tag.index') }}"><i class="ion ion-pricetag"></i> Master Tag</a></li>
        <li class="active">Add Tag</li>
    </ol>
@endsection

@section('main-content')
    <div class="container">
        <div class="col-lg-offset-2">
            {{ Form::open() }}
                @include('layouts.master_data.tags.tag_form')
            {{ Form::close() }}
        </div>
    </div>
@endsection