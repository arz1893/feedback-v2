@extends('home')

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Question List</li>
    </ol>
    <h3 class="text-success"> Question List </h3>
@endsection

@section('main-content')


    @if(\Session::has('status'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            {{ \Session::get('status') }}
        </div>
    @endif

    @php $counter = 1; @endphp
    <table id="table_question" class="table table-striped table-bordered table-responsive" style="width: 100%;">
        <thead>
        <tr>
            <th>No.</th>
            <th>Question</th>
            <th>Created</th>
            <th>Customer</th>
            <th>Need Call ?</th>
            <th>Is Answered ?</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($questions as $question)
            <tr>
                <td>{{ $counter }}</td>
                <td>
                    <a href="{{ route('question_list.show', $question->systemId) }}">{{ $question->question }} </a>
                </td>
                <td>
                    {{ $question->created_at->format('d-M-Y') }}
                </td>
                <td>
                    @if($question->customerId == null)
                        <a>Anonymous</a>
                    @else
                        <a>
                            {{ $question->customer->name }}
                        </a>
                    @endif
                </td>
                <td>
                    {!! $question->is_need_call == 1 ? '<span class="text-red">yes</span>':'<span class="text-muted">no</span>' !!}
                </td>
                <td>
                    {!! $question->is_answered == 1 ? '<span class="text-red">yes</span>':'<span class="text-muted">no</span>' !!}
                </td>
                <td>
                    <a href="{{ route('question_list.edit', $question->systemId) }}" class="btn btn-sm btn-warning">
                        <i class="fa fa-pencil-square"></i> Edit
                    </a>
                    <a href="#"
                       onclick="deleteItem(this)"
                       class="btn btn-sm btn-danger"
                       data-type="question"
                       data-id="{{ $question->systemId }}">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                </td>
            </tr>
            @php $counter++; @endphp
        @endforeach
        </tbody>
    </table>

    <!-- Modal Remove Complaint -->
    <div class="modal fade" id="modal_delete_question" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-danger" id="myModalLabel">Add Complaint</h4>
                </div>
                {{ Form::open(['action' => 'Question\QuestionListController@deleteQuestion', 'id' => 'form_delete_question']) }}

                <div class="modal-body">
                    Are you sure want to delete this complaint ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Remove Complaint</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection