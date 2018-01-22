@push('scripts')
    <script src="{{ asset('js/vue/vue_customer.js') }}" type="text/javascript"></script>
@endpush

@extends('home')

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('question_list.index') }}"><i class="fa fa-question-circle"></i> Question </a></li>
        <li class="active">Edit Question</li>
    </ol>
    <h3></h3>
@endsection

@section('main-content')

    @include('layouts.errors.error_list')

    <div class="col-lg-8">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h1 class="panel-title">Edit Question</h1>
            </div>
            <div class="panel-body">
                {{ Form::model($question, ['method' => 'PATCH', 'action' => ['Question\QuestionListController@update', $question]]) }}
                @include('layouts.question.edit_question_form')
                {{ Form::close() }}
            </div>
        </div>
    </div>

    @include('customer.manage_customer')
@endsection