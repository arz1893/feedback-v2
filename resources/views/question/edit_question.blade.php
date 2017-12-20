@extends('home')

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('question.index') }}"><i class="fa fa-question-circle"></i> Question </a></li>
        <li class="active">Edit Question</li>
    </ol>
    <h3> Edit Question </h3>
@endsection

@section('main-content')
    {{ Form::model($question, ['method' => 'PATCH', 'action' => ['Question\QuestionController@update', $question]]) }}
        @include('layouts.question.edit_question_form')
    {{ Form::close() }}
@endsection