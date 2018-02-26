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

    public function getAllStatistic(Request $request) {
        $complaintPerMonth = [];
        for($i=1;$i<=12;$i++) {
            array_push($complaintPerMonth, count(ComplaintProduct::whereMonth('created_at', '=', $i)->get()));
        }
        return $complaintPerMonth;
    }
}
