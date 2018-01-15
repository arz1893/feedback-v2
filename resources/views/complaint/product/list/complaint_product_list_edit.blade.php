@extends('home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/vue-animation/vue2-animate.css') }}"
          xmlns:v-on="http://www.w3.org/1999/xhtml">
@endpush

@push('scripts')
    <script src="{{ asset('js/vue/vue_complaint_product.js') }}" type="text/javascript"></script>
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
    <div id="vue_complaint_product_container">
        {{ Form::model($complaintProduct, ['method' => 'PATCH', 'action' => ['Complaint\ComplaintProductListController@update', $complaintProduct], 'id' => 'form_edit_complaint_product']) }}
        <div class="col-lg-6 col-lg-offset-3">
            @include('layouts.complaint.product.complaint_product_form', ['submitButtonText' => 'Update Complaint Product'])
        </div>
        {{ Form::close() }}
    </div>

    @include('customer.modal_add_customer')
@endsection