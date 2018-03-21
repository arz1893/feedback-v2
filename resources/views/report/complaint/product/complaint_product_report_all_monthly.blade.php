@extends('home')

@push('scripts')
    <script src="{{ asset('js/charts/complaint/product/complaint_product_chart.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('complaint_report.index') }}"><i class="fa fa-bar-chart-o"></i> Complaint Report Selection</a></li>
        <li><a href="{{ route('complaint_product_report.index') }}"><i class="fa fa-bar-chart-o"></i> Complaint Product Report Index</a></li>
        <li class="active">Complaint Product Monthly</li>
    </ol>
    <h3 class="text-red">Complaint Product All Report</h3>
@endsection

@section('main-content')
    <h3 class="text-center text-info">All Complaint in <span id="current_month"></span> <span id="current_year"></span></h3>

    <div class="col-lg-4 pull-right">
        <form class="form-inline">
            <div class="form-group">
                {{ Form::label('select_year', 'Select Year') }}
                {{ Form::selectYear('select_year', 1990, intval(date('Y')), intval(date('Y')), ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                {{ Form::label('select_month', 'Select Month') }}
                {{ Form::selectMonth('select_month', date('m'), ['class' => 'form-control']) }}
            </div>
        </form>
    </div>

    {{ Form::hidden('tenantId', Auth::user()->tenantId, ['id' => 'tenantId']) }}

    <div class="btn-group" role="group" aria-label="...">
        <a role="button" class="btn btn-xs btn-default">Daily</a>
        <a role="button" class="btn btn-xs btn-default">Weekly</a>
        <a role="button" class="btn btn-xs btn-default active">Monthly</a>
        <a href="{{ route('complaint_product_report_all_yearly') }}" role="button" class="btn btn-xs btn-default">Yearly</a>
    </div>

    <div id="not_found" class="well" style="margin-top: 3%; display: none;">
        <div class="text-center">
            There is no report found at current selected year and month
        </div>
    </div>

    <canvas id="complaint_product_chart_all_monthly" style="position: relative; height:55vh; width:80vw"></canvas>
@endsection