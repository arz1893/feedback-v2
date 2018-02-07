@extends('home')

@section('content-header')
    <h4> Edit Tag </h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('tag.index') }}"><i class="fa fa-tags"></i> Tags</a></li>
        <li class="active">Edit Tag</li>
    </ol>
@endsection

@section('main-content')
    <div class="container">
        <div class="col-lg-offset-3">
            {{ Form::model($tag, ['method' => 'PATCH', 'action' => ['MasterData\TagController@update', $tag], 'id' => 'form_tag']) }}
                @include('layouts.master_data.tags.tag_form', ['submitButtonText' => 'Add Tag'])
            {{ Form::close() }}
        </div>
    </div>
@endsection