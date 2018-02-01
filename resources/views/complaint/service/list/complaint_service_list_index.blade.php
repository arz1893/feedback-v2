@extends('home')

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Complaint Service List</li>
    </ol>
@endsection

@section('main-content')
    <h3 class="text-red">Complaint Service List</h3>

    @if(\Session::has('status'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            {{ \Session::get('status') }}
        </div>
    @endif

    <table class="table table-striped table-bordered table-responsive" id="table_complaint_service" style="width: 100%">
        <thead>
        <tr>
            <th>No.</th>
            <th>Complaint</th>
            <th>Created At</th>
            <th>Customer Name</th>
            <th>Service Name</th>
            <th>Rating</th>
            <th>Need Call ?</th>
            <th>Is Urgent ?</th>
            <th>Is Answered ?</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @php $counter = 1; @endphp
        @foreach($complaintServices as $complaintService)
            <tr>
                <td>{{ $counter }}</td>
                <td>
                    <a href="{{ route('complaint_service_list.show', $complaintService->systemId) }}">{{ $complaintService->customer_complaint }}</a>
                </td>
                <td>{{ $complaintService->created_at->format('d-M-Y') }}</td>
                <td>
                    <a>
                        @if($complaintService->customerId != null)
                            {{ $complaintService->customer->name }}
                        @else
                            Anonymous
                        @endif
                    </a>
                </td>
                <td>{{ $complaintService->service->name }}</td>
                <td>
                    @switch($complaintService->customer_rating)
                        @case(1)
                        <i class="text-center material-icons text-maroon" style="font-size: 2em;">
                            sentiment_very_dissatisfied
                        </i>
                        @break
                        @case(2)
                        <i class="text-center material-icons text-red" style="font-size: 2em;">
                            sentiment_dissatisfied
                        </i>
                        @break
                        @case(3)
                        <i class="smiley_rating material-icons text-yellow" style="font-size: 2em;">
                            sentiment_neutral
                        </i>
                        @break
                        @case(4)
                        <i class="smiley_rating material-icons text-olive" style="font-size: 2em;">
                            sentiment_satisfied
                        </i>
                        @break
                        @case(5)
                        <i class="smiley_rating material-icons text-green" style="font-size: 2em;">
                            sentiment_very_satisfied
                        </i>
                        @break
                    @endswitch
                </td>
                <td>{!! $complaintService->is_need_call == 1 ? '<span class="text-green">yes</span>':'<span class="text-red">no</span>' !!}</td>
                <td>{!! $complaintService->is_urgent == 1 ? '<span class="text-green">yes</span>':'<span class="text-red">no</span>' !!}</td>
                <td>{!! count($complaintService->complaint_service_replies) > 0 ? '<span class="text-green">yes</span>':'<span class="text-red">no</span>' !!}</td>
                <td>
                    @if(Auth::user()->user_group->name == 'Administrator' || Auth::user()->user_group->name == 'Management')
                        <a href="{{ route('complaint_service_list.show', $complaintService->systemId) }}"
                           class="btn btn-primary"
                           data-toggle="tooltip"
                           data-placement="bottom"
                           title="Answer">
                            <i class="fa fa-phone"></i>
                        </a>
                        <a href="{{ route('complaint_service_list.edit', $complaintService->systemId) }}" class="btn btn-warning">
                            <i class="ion ion-edit"></i>
                        </a>
                        <button class="btn btn-danger" data-id="{{ $complaintService->systemId }}" onclick="deleteComplaintService(this)">
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
    <div class="modal fade" id="modal_remove_complaint_service" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-danger" id="myModalLabel">Add Complaint</h4>
                </div>
                {{ Form::open(['action' => 'Complaint\ComplaintServiceListController@deleteComplaintService', 'id' => 'form_delete_complaint_service']) }}

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