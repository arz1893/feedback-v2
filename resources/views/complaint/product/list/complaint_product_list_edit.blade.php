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
            </div>

            <div class="col-lg-4">
                {{ Form::open(['action' => ['Complaint\ComplaintProductListController@changeAttachment', $complaintProduct->systemId], 'id' => 'form_change_attachment', 'files' => true]) }}
                <div class="form-group">
                    {{ Form::label('attachment', 'Attach a File') }}
                    {{ Form::file('attachment', ['class' => 'form-control-file', 'accept' => 'image/*', 'v-on:change' => 'submitFormAttachment($event)']) }}
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
                                <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> attachment</a>
                                <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                            </div>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </div>

    @include('customer.manage_customer')
@endsection