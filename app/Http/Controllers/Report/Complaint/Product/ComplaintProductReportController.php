<?php

namespace App\Http\Controllers\Report\Complaint\Product;

use App\ComplaintProduct;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ComplaintProductReportController extends Controller
{
    public function index() {
        $selectTags = Tag::where('recOwner', Auth::user()->tenantId)->orderBy('name', 'asc')->pluck('name', 'systemId');
        $defaultTags = Tag::where('recOwner', Auth::user()->tenantId)->where('defValue', 1)->orderBy('name', 'asc')->pluck('systemId');
        return view('report.complaint.product.complaint_product_report_index', compact('selectTags', 'defaultTags'));
    }

    public function showAllReport() {
        return view('report.complaint.product.complaint_product_report_all');
    }

    public function getAllReportYearly(Request $request) {

    }
}
