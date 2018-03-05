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

    public function showAllYearGraph(Request $request) {
        return view('report.complaint_service.complaint_service_report_all_year');
    }

    public function showMonthlyGraph(Request $request) {
        return view('report.complaint_service.complaint_service_report_yearly');
    }

    public function getAllYearComplaint(Request $request) {
        $oldest = ComplaintService::where('tenantId', $request->tenantId)->oldest()->first()->created_at->format('Y');
        $latest = ComplaintService::where('tenantId', $request->tenantId)->latest()->first()->created_at->format('Y');
        $labels = [];
        $complaintPerYear = [];

        for($i=intval($oldest);$i<=intval($latest);$i++) {
            array_push($labels, strval($i));
            array_push($complaintPerYear, count(ComplaintService::where('tenantId', $request->tenantId)->whereYear('created_at', '=', $i)->get()));
        }

        return array($labels, $complaintPerYear);
    }

    public function getYearlyComplaint(Request $request, $year) {
        $complaintPerMonth = [];
        $is_null = 0;
        for($i=1;$i<=12;$i++) {
            $totalPerMonth = count(ComplaintService::where('tenantId', $request->tenantId)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $i)->get());
            if($totalPerMonth == 0) {
                $is_null++;
            }
            array_push($complaintPerMonth, $totalPerMonth);
        }

        if($is_null == 12) {
            return null;
        } else {
            return $complaintPerMonth;

        }
    }
}
