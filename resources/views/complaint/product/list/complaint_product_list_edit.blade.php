@extends('home')

@push('scripts')
    <script src="{{ asset('js/vue/vue_product.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vue/vue_customer.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h4>Edit Complaint Product</h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('complaint_product_list.index') }}"><i class="ion ion-clipboard"></i>Complaint Product List</a></li>
        <li><a href="{{ route('complaint_product_list.show', $complaintProduct->systemId) }}"><i class="ion ion-ios-search"></i>Complaint Product Detail</a></li>
        <li class="active">Edit Complaint Product</li>
    </ol>
@endsection

@section('main-content')
    <div id="vue_product_container">

        @if(\Session::has('status'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                {{ \Session::get('status') }}
            </div>
        @endif

        <div class="row">
            <div class="col-lg-6">
                {{ Form::model($complaintProduct, ['method' => 'PATCH', 'action' => ['Complaint\ComplaintProductListController@update', $complaintProduct], 'id' => 'form_edit_complaint_product', 'files' => true]) }}
                @include('layouts.complaint.product.complaint_product_form_edit', ['submitButtonText' => 'Update Complaint Product'])
                {{ Form::close() }}
            </div> <br>

            <div class="col-lg-4">
                {{ Form::open(['action' => ['Complaint\ComplaintProductListController@changeAttachment', $complaintProduct->systemId], 'id' => 'form_change_attachment', 'files' => true]) }}
                    <div class="form-group">
                        {{ Form::label('attachment', 'Change or add attachment') }}
                        {{ Form::file('attachment', ['class' => 'form-control-file', 'accept' => 'image/*', 'onchange' => '$("#form_change_attachment").submit()']) }}
                        @if($complaintProduct->attachment == null)
                            <p class="help-block">You don't have any attachment yet</p>
                        @endif
                    </div>
                {{ Form::close() }}

                @if($complaintProduct->attachment != null)
                    <span class="text-muted">Current Attachment : </span>
                    <ul class="mailbox-attachments clearfix">
                        <li>
                            <div id="lightgallery">
                                <a href="{{ asset($complaintProduct->attachment) }}">
                                <span class="mailbox-attachment-icon has-img">
                                    <img src="{{ asset($complaintProduct->attachment) }}" alt="Attachment">
                                </span>
                                </a>
                            </div>

                            <div class="mailbox-attachment-info">
                                <a class="btn btn-danger btn-xs pull-right"
                                   data-id="{{ $complaintProduct->systemId  }}"
                                   data-type="delete_complaint_product_attachment"
                                   onclick="deleteItem(this)"
                                   data-toggle="tooltip"
                                   data-placement="bottom"
                                   title="delete attachment">
                                    <i class="fa fa-close"></i>
                                </a>
                                <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> attachment</a>
                            </div>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Remove Complaint -->
    <div class="modal fade" id="modal_remove_complaint_product_attachment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-danger" id="myModalLabel">Remove Attachment</h4>
                </div>
                {{ Form::open(['action' => 'Complaint\ComplaintProductListController@deleteAttachment', 'id' => 'form_delete_complaint_product_attachment']) }}

                <div class="modal-body">
                    Are you sure want to delete this attachment ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Remove Attachment</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    @include('customer.manage_customer')
@endsection