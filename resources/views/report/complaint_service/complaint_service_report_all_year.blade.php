@extends('home')

@push('scripts')
    <script src="{{ asset('js/charts/complaint_service_chart.js') }}" type="text/javascript"></script>
@endpush
@section('content-header')
    <h3 style="margin-top: -0.5%" class="text-info">Complaint Service Report</h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('complaint_service_report.index') }}"><i class="fa fa-bar-chart"></i>  Complaint Service Report </a></li>
        <li class="active"> All Year </li>
    </ol>
@endsection

@section('main-content')
    {{ Form::hidden('tenant_id', Auth::user()->tenantId, ['id' => 'tenant_id']) }}
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6"></div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group pull-right">
                <div class="btn-group" role="group" aria-label="...">
                    <a href="{{ route('product_report_all_year') }}" type="button" class="btn btn-sm btn-info">All Year</a>
                    <a href="{{ route('product_report_yearly') }}" type="button" class="btn btn-sm btn-info">Yearly</a>
                    <a type="button" class="btn btn-sm btn-info">Monthly</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <h4 class="text-center text-info">All Complaint Summary</h4>
    </div>

    <div id="no_data_found" class="col-lg-6 col-lg-offset-3" style="display: none;">
        <div class="well text-center">
            There is no complaint added yet
        </div>
    </div>

    <canvas id="complaint_service_chart_all_year" height="30vh" width="80vw" style="position: relative"></canvas>
@endsection