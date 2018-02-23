@extends('home')

@push('scripts')
    <script src="{{ asset('js/vue/vue_service.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vue/vue_customer.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h4>Edit Complaint Service</h4>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('complaint_service_list.index') }}"><i class="ion ion-clipboard"></i>Complaint Service List</a></li>
        <li class="active">Edit Complaint Service</li>
    </ol>
@endsection

@section('main-content')
    <div id="vue_service_container">

        @if(\Session::has('status'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                {{ \Session::get('status') }}
            </div>
        @endif

        <div class="row">
            <div class="col-lg-6" style="margin-top: 2%;">
                {{ Form::model($complaintService, ['method' => 'PATCH', 'action' => ['Complaint\ComplaintServiceListController@update', $complaintService], 'id' => 'form_edit_complaint_service', 'files' => true]) }}
                @include('layouts.complaint.service.complaint_service_form_edit', ['submitButtonText' => 'Update Complaint Service'])
                {{ Form::close() }}
            </div>

            <div class="col-lg-4" style="margin-top: 2%;">
                {{ Form::open(['action' => ['Complaint\ComplaintServiceListController@changeAttachment', $complaintService->systemId], 'id' => 'form_change_complaint_service_attachment', 'files' => true]) }}
                <div class="form-group">
                    {{ Form::label('attachment', 'Attach a File') }}
                    {{ Form::file('attachment', ['class' => 'form-control-file', 'accept' => 'image/*', 'onchange' => '$("#form_change_complaint_service_attachment").submit()']) }}
                    @if($complaintService->attachment != null)
                        <p class="help-block">Click here to change current attachment</p>
                    @endif
                </div>

                @if($complaintService->attachment != null)
                    <span class="text-muted">Current Attachment : </span>
                    <ul class="mailbox-attachments clearfix">
                        <li>
                            <div id="lightgallery">
                                <a href="{{ asset($complaintService->attachment) }}">
                                    <span class="mailbox-attachment-icon has-img">
                                        <img src="{{ asset($complaintService->attachment) }}" alt="Attachment">
                                    </span>
                                </a>
                            </div>

                            <div class="mailbox-attachment-info">
                                <a class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> attachment</a>
                                <a class="btn btn-danger btn-xs pull-right"
                                        data-id="{{ $complaintService->systemId }}"
                                        data-type="delete_complaint_service_attachment"
                                        onclick="deleteItem(this)">
                                    <i class="fa fa-close"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                @endif
            </div>
            {{ Form::close() }}
        </div>
    </div>

    <!-- Modal Remove Complaint -->
    <div class="modal fade" id="modal_remove_complaint_service_attachment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-danger" id="myModalLabel">Remove Attachment</h4>
                </div>
                {{ Form::open(['action' => 'Complaint\ComplaintServiceListController@deleteAttachment', 'id' => 'form_delete_complaint_service_attachment']) }}

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
