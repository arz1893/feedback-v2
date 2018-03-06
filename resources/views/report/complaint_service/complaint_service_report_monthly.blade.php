@extends('home')

@section('content-header')
    {{ Form::hidden('tenant_id', Auth::user()->tenantId, ['id' => 'tenant_id']) }}
    <h3 style="margin-top: -0.5%">Complaint Service Report</h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('complaint_service_report.index') }}"><i class="fa fa-bar-chart"></i> Complaint Service Report</a></li>
        <li class="active">Show Monthly </li>
    </ol>
@endsection

@section('main-content')

@endsection