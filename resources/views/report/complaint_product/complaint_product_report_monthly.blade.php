@extends('home')

@section('content-header')
    <h3 style="margin-top: -0.5%" class="text-info">Complaint Product Report</h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('complaint_product_report.index') }}"><i class="fa fa-bar-chart"></i>  Complaint Product Report </a></li>
        <li class="active"> Show Monthly </li>
    </ol>
@endsection

@section('main-content')

@endsection