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
        <div class="col-lg-6">
            {{ Form::model($complaintService, ['method' => 'PATCH', 'action' => ['Complaint\ComplaintServiceListController@update', $complaintService], 'id' => 'form_edit_complaint_service']) }}
            @include('layouts.complaint.service.complaint_service_form_edit', ['submitButtonText' => 'Update Complaint Service'])
            {{ Form::close() }}
        </div>
    </div>

    @include('customer.manage_customer')
@endsection
