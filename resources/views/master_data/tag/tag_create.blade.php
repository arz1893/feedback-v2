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
    @include('layouts.errors.error_list')

    <div class="container">
        <div class="col-lg-offset-3">
            {{ Form::open(['action' => 'MasterData\TagController@store', 'id' => 'form_tag']) }}
                @include('layouts.master_data.tags.tag_form', ['submitButtonText' => 'Update Tag'])
            {{ Form::close() }}
        </div>
    </div>
@endsection