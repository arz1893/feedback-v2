@push('scripts')
    <script src="{{ asset('js/charts/complaint_product_chart.js') }}" type="text/javascript"></script>
@endpush

@extends('home')

@section('content-header')
    <h3 style="margin-top: -0.5%">Complaint Product Report</h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-bar-chart"></i> Complaint Product Report </li>
    </ol>
@endsection

@section('main-content')
    <div class="btn-group" role="group" aria-label="...">
        <button type="button" class="btn btn-info">Month</button>
        <button type="button" class="btn btn-info">Week</button>
        <button type="button" class="btn btn-info">Days</button>
    </div>
    <canvas id="complaint_product_chart" height="30vh" width="80vw"></canvas>
@endsection