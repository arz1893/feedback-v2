@extends('home')

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Question List</li>
    </ol>
    <h3> Question List </h3>
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
    <table id="table_question" class="table table-responsive table-hover" style="width: 100%;">
        <thead>
        <tr>
            <th>Num.</th>
            <th>Customer</th>
            <th>Question</th>
            <th>Need Call ?</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($questions as $question)
            <tr>
                <td>{{ $counter }}</td>
                <td>
                    @if($question->customerId == null)
                        <a>Anonymous</a>
                    @else
                        <a>
                            {{ $question->customer->name }}
                        </a>
                    @endif
                </td>
                <td> {{ $question->question }} </td>

                <td>
                    @if($question->is_need_call == 1)
                        Yes
                    @else
                        No
                    @endif
                </td>
                <td>
                    <a href="{{ route('question_list.edit', $question->systemId) }}" class="btn btn-sm btn-warning">
                        <i class="fa fa-pencil-square"></i> Edit
                    </a>
                    {{--<a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#myModal">--}}
                    {{--<i class="fa fa-trash"></i> Delete--}}
                    {{--</a>--}}
                </td>
            </tr>
            @php $counter++; @endphp
        @endforeach
        </tbody>
    </table>
@endsection