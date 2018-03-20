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

    public function showAllReportYearly() {
        return view('report.complaint.product.complaint_product_report_all_yearly');
    }

    public function showAllDataMonthly(Request $request, $tenantId) {
        $complaintProducts = ComplaintProduct::where('tenantId', $tenantId)->whereYear('created_at', date('Y'))->orderBy('created_at', 'asc')->get();
        $tempLabels = [];
        $tempDatas = array();

        foreach ($complaintProducts as $complaintProduct) {
            if(!in_array($complaintProduct->product->name, $tempLabels)) {
                array_push($tempLabels, $complaintProduct->product->name);
                array_push($tempDatas, 0);
            }
        }

        foreach ($complaintProducts as $complaintProduct) {
            $index = array_search($complaintProduct->product->name, $tempLabels);
            $tempDatas[$index] += 1;
        }

        for($i=0;$i<count($tempDatas);$i++) {
            $val = $tempDatas[$i];
            for($j=$i;$j<count($tempDatas);$j++) {
                if($tempDatas[$j] > $val) {
                    $val = $tempDatas[$j];
                    $tempDatas[$j] = $tempDatas[$i];
                    $tempDatas[$i] = $val;

                    $label = $tempLabels[$j];
                    $tempLabels[$j] = $tempLabels[$i];
                    $tempLabels[$i] = $label;
                }
            }
        }

//        for($i=0;$i<count($complaintProducts);$i++) {
//            for($j=0;$j<count($complaintProducts);$j++) {
//                if($tempLabels[$i] == $complaintProducts[$j]->product->name) {
//                    $tempDatas[$i] += 1;
//                }
//            }
//        }

        return ['labels' => array_slice($tempLabels, 0, 10), 'data' => array_slice($tempDatas, 0, 10)];
    }
}
