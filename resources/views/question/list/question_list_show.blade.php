@extends('home')

@push('scripts')
    <script src="{{ asset('js/vue/vue_question.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('question_list.index') }}"><i class="fa fa-list"></i> Question List</a></li>
        <li class="active">Question Detail</li>
    </ol>
    <h3 class="text-success"> Question Detail </h3>
@endsection

@section('main-content')
    <div class="container">
        @include('layouts.errors.error_list')

        @if(\Session::has('status'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Info!</strong> {{ \Session::get('status') }}
            </div>
        @endif

        <h3 class="text-center text-info">Q: {{ $question->question }}</h3>

        @if($question->answer != null)
            <div id="vue_question_container">
                <div class="well" id="vue_question_container">
                    <p class="text-justify">
                        <strong>Answer :</strong><br>
                        <span id="answer_content">{{ $question->answer }}</span>
                    </p>
                    <button class="btn btn-warning" @click="editQuestion($event)">
                        <i class="fa fa-pencil-square"></i> Edit
                    </button>
                    <button class="btn btn-danger" data-id="{{ $question->systemId }}" data-type="delete_answer" onclick="deleteItem(this)">
                        <i class="fa fa-trash-o"></i> Delete
                    </button>
                </div>

                <div class="box box-warning box-solid" id="box_edit_answer" style="display: none;">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        {{ Form::open(['action' => ['Question\QuestionListController@updateAnswer', $question->systemId]]) }}
                        <div class="form-group">
                            {{ Form::textarea('answer', null, ['class' => 'form-control', 'rows' => 6, 'placeholder' => 'Enter answer', 'v-model' => 'default_text']) }}
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success">
                                <i class="ion ion-android-send"></i> Update
                            </button>
                        </div>
                        {{ Form::close() }}
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        @endif

        @if($question->answer == null)
            {{ Form::open(['action' => ['Question\QuestionListController@answerQuestion', $question->systemId], 'id' => 'form_answer_question']) }}
            <div class="form-group">
                {{ Form::label('answer', 'Answer : ') }}
                {{ Form::textarea('answer', null, ['class' => 'form-control', 'rows' => 6, 'placeholder' => 'Enter answer']) }}
            </div>
            <div class="form-group">
                <button class="btn btn-success" type="submit">
                    <i class="ion ion-android-send"></i> Submit
                </button>
            </div>
            {{ Form::close() }}
        @endif
    </div>

    <!-- Modal Remove Complaint -->
    <div class="modal fade" id="modal_delete_answer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-danger" id="myModalLabel">Delete Answer</h4>
                </div>
                {{ Form::open(['action' => 'Question\QuestionListController@deleteAnswer', 'id' => 'form_delete_answer']) }}

                <div class="modal-body">
                    Are you sure want to delete this answer ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Remove Answer</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection