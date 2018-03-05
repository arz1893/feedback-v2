<?php

namespace App\Http\Controllers\Report;

use App\ComplaintProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ComplaintProductReportController extends Controller
{
    public function index() {
        return view('report.complaint_product.complaint_product_report_index');
    }

    public function showAllYearGraph(Request $request) {
        return view('report.complaint_product.complaint_product_report_all_year');
    }

    public function showYearlyGraph(Request $request) {
        return view('report.complaint_product.complaint_product_report_yearly');
    }

    public function getYearlyComplaint(Request $request, $year) {
        $complaintPerMonth = [];
        $is_null = 0;
        for($i=1;$i<=12;$i++) {
            $totalPerMonth = count(ComplaintProduct::where('tenantId', $request->tenantId)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $i)->get());
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

    public function getAllYearComplaint(Request $request) {
        $oldest = ComplaintProduct::where('tenantId', $request->tenantId)->oldest()->first()->created_at->format('Y');
        $latest = ComplaintProduct::where('tenantId', $request->tenantId)->latest()->first()->created_at->format('Y');
        $labels = [];
        $complaintPerYear = [];

        for($i=intval($oldest);$i<=intval($latest);$i++) {
            array_push($labels, strval($i));
            array_push($complaintPerYear, count(ComplaintProduct::where('tenantId', $request->tenantId)->whereYear('created_at', '=', $i)->get()));
        }

        return array($labels, $complaintPerYear);
    }
}
