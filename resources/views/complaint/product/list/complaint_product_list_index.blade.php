@extends('home')

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Complaint Product List</li>
    </ol>
@endsection

@section('main-content')
    <h3 class="text-red">Complaint Product List</h3>

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
            <th>Product Name</th>
            <th>Category</th>
            <th>Customer's Rating</th>
            <th>Complaint content</th>
            <th>Need Call ?</th>
            <th>Is Urgent ?</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @php $counter = 1; @endphp
        @foreach($complaintProducts as $complaintProduct)
            <tr>
                <td>{{ $counter }}</td>
                <td>
                    <a>
                        @if($complaintProduct->customerId != null)
                            {{ $complaintProduct->customer->name }}
                        @else
                            Anonymous
                        @endif
                    </a>
                </td>
                <td>{{ $complaintProduct->product->name }}</td>
                <td>{{ $complaintProduct->product_category->name }}</td>
                <td>{{ $complaintProduct->customer_rating }}</td>
                <td>{{ $complaintProduct->customer_complaint }}</td>
                <td>{!! $complaintProduct->is_need_call == 1 ? '<span class="text-red">yes</span>':'<span class="blue-text">no</span>' !!}</td>
                <td>{!! $complaintProduct->is_urgent == 1 ? '<span class="text-red">yes</span>':'<span class="blue-text">no</span>' !!}</td>
                <td>
                    @if(Auth::user()->user_group->name == 'Administrator' || Auth::user()->user_group->name == 'Management')
                        <a href="{{ route('complaint_product_list.edit', $complaintProduct->systemId) }}" class="btn btn-warning">
                            <i class="ion ion-edit"></i>
                        </a>
                        <button class="btn btn-danger" data-id="{{ $complaintProduct->systemId }}" onclick="deleteComplaintProduct(this)">
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
    <div class="modal fade" id="modal_remove_complaint_product" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-danger" id="myModalLabel">Add Complaint</h4>
                </div>
                {{ Form::open(['action' => 'Complaint\ComplaintProductListController@deleteComplaintProduct', 'id' => 'form_delete_complaint_product']) }}

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