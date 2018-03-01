@extends('home')

@push('scripts')
    <script src="{{ asset('js/charts/complaint_service_chart.js') }}" type="text/javascript"></script>
@endpush

@section('content-header')
    {{ Form::hidden('tenant_id', Auth::user()->tenantId, ['id' => 'tenant_id']) }}
    <h3 style="margin-top: -0.5%">Complaint Service Report</h3>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('complaint_service_report.index') }}"><i class="fa fa-bar-chart"></i> </i> Complaint Service Report</a></li>
        <li class="active">Show Monthly </li>
    </ol>
@endsection

@section('main-content')
    <div class="col-lg-6 col-md-6 col-sm-6 form-inline">
        <div class="form-group">
            <label for="select_year">Select year:</label>
            <select name="select_year" id="select_year" class="form-control">
                <option value="0" selected disabled>Choose...</option>
                @for($i=2000;$i<=intval(date('Y'));$i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="form-group pull-right">
            <div class="btn-group" role="group" aria-label="...">
                <button type="button" class="btn btn-sm btn-info">Yearly</button>
                <button type="button" class="btn btn-sm btn-info">Monthly</button>
                <button type="button" class="btn btn-sm btn-info">Weekly</button>
            </div>
        </div>
    </div>

    <canvas id="complaint_service_chart" height="30vh" width="80vw"></canvas>
@endsection