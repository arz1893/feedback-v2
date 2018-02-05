@push('scripts')
    <script src="{{ asset('js/vue/vue_customer.js') }}" type="text/javascript"></script>
@endpush

@extends('home')

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-question-circle"></i> Question </li>
    </ol>
    <h3>Question Section</h3>
@endsection

@section('main-content')
    @if(\Session::has('status'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Info!</strong> {{ \Session::get('status') }}
        </div>
    @endif

    @include('layouts.errors.error_list')

    <div class="row">
        <div class="col-lg-6">
            {{ Form::open(['action' => 'Question\QuestionController@store', 'id' => 'form_add_question']) }}
                @include('layouts.question.add_question_form')
            {{ Form::close() }}
        </div>
    </div>

    @include('customer.manage_customer')
@endsection