<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ComplaintProductReport extends Controller
{
    public function index() {
        return view('report.complaint_product.complaint_product_report_index');
    }
}
