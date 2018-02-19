@extends('home')

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Suggestion Service List</li>
    </ol>
@endsection

@section('main-content')
    <h3 class="text-orange">Suggestion Service List</h3>

    @if(\Session::has('status'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            {{ \Session::get('status') }}
        </div>
    @endif

    <table class="table table-striped table-bordered table-responsive" id="table_suggestion_service" style="width: 100%">
        <thead>
        <tr>
            <th>No.</th>
            <th>Created At</th>
            <th>Customer Name</th>
            <th>Service Name</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @php $counter = 1; @endphp
        @foreach($suggestionServices as $suggestionService)
            <tr>
                <td>{{ $counter }}</td>
                <td>{{ $suggestionService->created_at->format('d-M-Y') }}</td>
                <td>
                    <a href="{{ route('suggestion_service_list.show', $suggestionService->systemId) }}">
                        @if($suggestionService->customerId != null)
                            {{ $suggestionService->customer->name }}
                        @else
                            Anonymous
                        @endif
                    </a>
                </td>
                <td>{{ $suggestionService->service->name }}</td>
                <td>{{ $suggestionService->service_category->name }}</td>
                <td>
                    @if(Auth::user()->user_group->name == 'Administrator' || Auth::user()->user_group->name == 'Management')
                        <a href="{{ route('suggestion_service_list.edit', $suggestionService->systemId) }}" class="btn btn-warning">
                            <i class="ion ion-edit"></i>
                        </a>
                        <button class="btn btn-danger" data-id="{{ $suggestionService->systemId }}" onclick="deleteSuggestionService(this)">
                            <i class="ion ion-ios-trash"></i>
                        </button>
                    @else
                        <span class="text-red">Not Authorized</span>
                    @endif
                </td>
            </tr>
            @php $counter++; @endphp
        @endforeach
        </tbody>
    </table>

    <!-- Modal Remove Complaint -->
    <div class="modal fade" id="modal_remove_suggestion_service" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-danger" id="myModalLabel">Add Complaint</h4>
                </div>
                {{ Form::open(['action' => 'Suggestion\SuggestionServiceListController@deleteSuggestionService', 'id' => 'form_delete_suggestion_service']) }}

                <div class="modal-body">
                    Are you sure want to delete this complaint ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Remove Suggestion</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection