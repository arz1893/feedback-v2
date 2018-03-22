@extends('home')

@push('scripts')
    <script src="{{ asset('js/charts/complaint/service/complaint_service_chart.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('complaint_report.index') }}"><i class="fa fa-bar-chart-o"></i> Complaint Report Selection</a></li>
        <li><a href="{{ route('complaint_service_report.index') }}"><i class="fa fa-bar-chart-o"></i> Complaint Service Report Index</a></li>
        <li class="active">Complaint Service Yearly</li>
    </ol>
    <h3 class="text-red">Complaint Service All Report</h3>
@endsection

@section('main-content')
    <h3 class="text-center text-info">All Complaint in <span id="current_year"></span></h3>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2">
                <div class="form-inline">
                    <div class="form-group">
                        {{ Form::label('show_data', 'Show') }}
                        {{ Form::select('show_data', ['10' => '10', '50' => '50', '100' => '100'], 10, ['class' => 'form-control']) }}
                    </div>
                </div>
            </div>

            <div class="col-lg-2 pull-right">
                <form class="form-inline pull-right">
                    <div class="form-group">
                        {{ Form::label('select_year', 'Select Year') }}
                        {{ Form::selectYear('select_year', 1990, intval(date('Y')), intval(date('Y')), ['class' => 'form-control']) }}
                    </div>
                </form>
            </div>
        </div>
    </div> <br> <br>

    {{ Form::hidden('tenantId', Auth::user()->tenantId, ['id' => 'tenantId']) }}

    <div class="btn-group" role="group" aria-label="...">
        <a role="button" class="btn btn-xs btn-default">Daily</a>
        <a role="button" class="btn btn-xs btn-default">Weekly</a>
        <a role="button" href="{{ route('complaint_service_report_all_monthly') }}" class="btn btn-xs btn-default">Monthly</a>
        <a role="button" class="btn btn-xs btn-default active">Yearly</a>
    </div>

    <div id="not_found" class="well" style="margin-top: 3%; display: none;">
        <div class="text-center">
            There is no report found at current year
        </div>
    </div>

    <canvas id="complaint_service_chart_all_yearly" style="position: relative; height:55vh; width:80vw"></canvas>
@endsection