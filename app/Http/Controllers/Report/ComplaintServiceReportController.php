<?php

namespace App\Http\Controllers\Report;

use App\ComplaintService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ComplaintServiceReportController extends Controller
{
    public function index() {
        return view('report.complaint_service.complaint_service_report_index');
    }

    public function showMonthlyGraph(Request $request) {
        return view('report.complaint_service.complaint_service_report_monthly');
    }

    public function getMonthlyComplaint(Request $request, $year) {
        $complaintPerMonth = [];
        for($i=1;$i<=12;$i++) {
            $totalPerMonth = count(ComplaintService::where('tenantId', $request->tenantId)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $i)->get());
            array_push($complaintPerMonth, $totalPerMonth);
        }
        return $complaintPerMonth;
    }
}
