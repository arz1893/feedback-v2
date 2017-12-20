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

    <table class="table table-striped" id="table_complaint_product" style="width: 100%">
        <thead>
        <tr>
            <th>No.</th>
            <th>Customer Name</th>
            <th>Service Name</th>
            <th>Category</th>
            <th>Complaint content</th>
            <th>Need Call ?</th>
            <th>Is Urgent ?</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @php $counter = 1; @endphp
        @foreach($complaintServices as $complaintService)
            <tr>
                <td>{{ $counter }}</td>
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
                <td>{{ $complaintService->service_category->name }}</td>
                <td>{{ $complaintService->customer_complaint }}</td>
                <td>{!! $complaintService->is_need_call == 1 ? '<span class="text-red">yes</span>':'<span class="blue-text">no</span>' !!}</td>
                <td>{!! $complaintService->is_urgent == 1 ? '<span class="text-red">yes</span>':'<span class="blue-text">no</span>' !!}</td>
                <td>
                    <a href="{{ route('complaint_service_list.edit', $complaintService->systemId) }}" class="btn btn-warning">
                        <i class="ion ion-edit"></i>
                    </a>
                    <button class="btn btn-danger" data-id="{{ $complaintService->systemId }}" onclick="deleteComplaintService(this)">
                        <i class="ion ion-ios-trash"></i>
                    </button>
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