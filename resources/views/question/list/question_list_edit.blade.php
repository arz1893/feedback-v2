@extends('home')

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('question_list.index') }}"><i class="fa fa-question-circle"></i> Question </a></li>
        <li class="active">Edit Question</li>
    </ol>
    <h3> Edit Question </h3>
@endsection

@section('main-content')

    @include('layouts.errors.error_list')

    {{ Form::model($question, ['method' => 'PATCH', 'action' => ['Question\QuestionListController@update', $question]]) }}
        @include('layouts.question.edit_question_form')
    {{ Form::close() }}

    @include('customer.modal_add_customer')
@endsection