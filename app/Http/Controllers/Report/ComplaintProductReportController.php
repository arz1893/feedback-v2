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

    public function showMonthlyGraph(Request $request) {
        return view('report.complaint_product.complaint_product_report_monthly');
    }

    public function getAllStatistic(Request $request, $year) {
        $complaintPerMonth = [];
        for($i=1;$i<=12;$i++) {
            $totalPerMonth = count(ComplaintProduct::where('tenantId', $request->tenantId)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $i)->get());
            array_push($complaintPerMonth, $totalPerMonth);
        }

        if(count($complaintPerMonth) > 0) {
            return $complaintPerMonth;
        } else {
            return null;
        }
    }
}
