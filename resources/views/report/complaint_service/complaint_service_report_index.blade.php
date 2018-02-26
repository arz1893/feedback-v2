@extends('home')

@push('scripts')
    <script src="{{ asset('js/charts/complaint_service_chart.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <h3 style="margin-top: -0.5%">Complaint Service Report</h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-bar-chart"></i> Complaint Service Report </li>
    </ol>
@endsection

@section('main-content')
    <div class="btn-group" role="group" aria-label="...">
        <button type="button" class="btn btn-info">Month</button>
        <button type="button" class="btn btn-info">Week</button>
        <button type="button" class="btn btn-info">Days</button>
    </div>

    <canvas id="complaint_service_chart" height="30vh" width="80vw"></canvas>
@endsection