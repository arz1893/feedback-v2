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
    <div class="row">
        <div class="col-lg-6">
            <div class="btn-group" role="group" aria-label="...">
                <button type="button" class="btn btn-info">Yearly</button>
                <button type="button" class="btn btn-info">Monthly</button>
                <button type="button" class="btn btn-info">Weekly</button>
            </div>
        </div>
        <div class="col-lg-6">
            <form class="form-horizontal">
                <div class="form-group">
                    <label for="select_year" class="col-sm-2 control-label">Select Year :</label>
                    <div class="col-sm-4">
                        <select name="select_year" id="select_year" class="select2-year" style="width: 100%;"></select>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <canvas id="complaint_product_chart" height="30vh" width="80vw"></canvas>
@endsection