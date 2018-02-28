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

    public function getAllStatistic(Request $request) {
        $complaintPerMonth = [];
        for($i=1;$i<=12;$i++) {
            array_push($complaintPerMonth, count(ComplaintService::whereMonth('created_at', '=', $i)->get()));
        }
        return $complaintPerMonth;
    }

    public function showMonthlyGraph(Request $request) {
        return view('report.complaint_service.complaint_service_report_monthly');
    }
}
