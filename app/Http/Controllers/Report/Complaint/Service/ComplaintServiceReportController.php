<?php

namespace App\Http\Controllers\Report\Complaint\Service;

use App\ComplaintService;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ComplaintServiceReportController extends Controller
{
    public function index() {
        $selectTags = Tag::where('recOwner', Auth::user()->tenantId)->orderBy('name', 'asc')->pluck('name', 'systemId');
        $defaultTags = Tag::where('recOwner', Auth::user()->tenantId)->where('defValue', 1)->orderBy('name', 'asc')->pluck('systemId');
        return view('report.complaint.service.complaint_service_report_index', compact('selectTags', 'defaultTags'));
    }

    public function showAllReportYearly() {
        return view('report.complaint.service.complaint_service_report_all_yearly');
    }

    public function showDataComplaintServiceYearly(Request $request, $tenantId, $year) {
        $complaintServices = ComplaintService::where('tenantId', $tenantId)->whereYear('created_at', $year)->orderBy('created_at', 'asc')->get();
        $tempLabels = [];
        $tempDatas = array();

        if(count($complaintServices) > 0) {
            foreach ($complaintServices as $complaintService) {
                if(!in_array($complaintService->service->name, $tempLabels)) {
                    array_push($tempLabels, $complaintService->service->name);
                    array_push($tempDatas, 0);
                }
            }

            foreach ($complaintServices as $complaintService) {
                $index = array_search($complaintService->service->name, $tempLabels);
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

            return ['labels' => $tempLabels, 'data' => $tempDatas];
        } else {
            return ['error' => 'not found'];
        }
    }
}
