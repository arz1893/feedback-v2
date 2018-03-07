<?php

namespace App\Http\Controllers\Report\Complaint;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ComplaintReportController extends Controller
{
    public function index() {
        return view('report.complaint.complaint_report_index');
    }

    public function showAllComplaintReport() {
        return view('report.complaint.complaint_report_all');
    }

}
