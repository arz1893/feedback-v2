@extends('home')

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('question.index') }}"><i class="fa fa-question-circle"></i> Question </a></li>
        <li class="active">Add Question</li>
    </ol>
    <h3> Add Question </h3>
@endsection

@section('main-content')

    @include('layouts.errors.error_list')

    @if(\Session::has('status'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Info!</strong> {{ \Session::get('status') }}
        </div>
    @endif

    {{ Form::open(['action' => 'Question\QuestionController@store']) }}
        @include('layouts.question.add_question_form')
    {{ Form::close() }}

    @include('customer.modal_add_customer')

@endsection