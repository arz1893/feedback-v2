@extends('home')

@push('scripts')
    <script src="{{ asset('js/vue/vue_product.js') }}" type="text/javascript"></script>
@endpush

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

    <div id="complaint_product_list_index">
        <table class="table table-striped table-bordered table-responsive" id="table_complaint_product" style="width: 100%">
            <thead>
            <tr>
                <th>No.</th>
                <th>Created at</th>
                <th>Customer Name</th>
                <th>Product Name</th>
                <th>Rating</th>
                <th>Need Call ?</th>
                <th>Is Urgent ?</th>
                <th>Is Answered ?</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @php $counter = 1; @endphp
            @foreach($complaintProducts as $complaintProduct)
                <tr>
                    <td>{{ $counter }}</td>
                    <td>
                        <a href="#!" data-toggle="modal" data-target="#modal_complaint_product_show" data-complaint_id="{{ $complaintProduct->systemId }}" @click="showComplaintDetail($event)">
                            {{ $complaintProduct->created_at->format('d-M-Y') }}
                        </a>
                    </td>
                    <td>
                        <a href="#!" data-toggle="modal" data-target="#modal_complaint_product_show" data-complaint_id="{{ $complaintProduct->systemId }}" @click="showComplaintDetail($event)">
                            @if($complaintProduct->customerId != null)
                                {{ $complaintProduct->customer->name }}
                            @else
                                Anonymous
                            @endif
                        </a>
                    </td>
                    <td>{{ $complaintProduct->product->name }}</td>
                    <td>
                        @switch($complaintProduct->customer_rating)
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
                    <td>{!! $complaintProduct->is_need_call == 1 ? '<span class="text-green">yes</span>':'<span class="text-red">no</span>' !!}</td>
                    <td>{!! $complaintProduct->is_urgent == 1 ? '<span class="text-green">yes</span>':'<span class="text-red">no</span>' !!}</td>
                    <td>{!! count($complaintProduct->complaint_product_replies) > 0 ? '<span class="text-green">yes</span>':'<span class="text-red">no</span>' !!}</td>
                    <td>
                        @if(Auth::user()->user_group->name == 'Administrator' || Auth::user()->user_group->name == 'Management')
                            <a href="{{ route('complaint_product_list.show', $complaintProduct->systemId) }}"
                               class="btn btn-primary"
                               data-toggle="tooltip"
                               data-placement="bottom"
                               title="Answer">
                                <i class="fa fa-phone"></i>
                            </a>
                            <a href="{{ route('complaint_product_list.edit', $complaintProduct->systemId) }}"
                               class="btn btn-warning"
                               data-toggle="tooltip"
                               data-placement="bottom"
                               title="Edit">
                                <i class="ion ion-edit"></i>
                            </a>
                            <button class="btn btn-danger"
                                    data-id="{{ $complaintProduct->systemId }}" onclick="deleteComplaintProduct(this)"
                                    data-toggle="tooltip"
                                    data-placement="bottom" title="Delete">
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

        @include('complaint.product.list.modal_complaint_product_list_show')

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
    </div>
@endsection