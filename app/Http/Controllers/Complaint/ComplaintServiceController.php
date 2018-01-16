<?php

namespace App\Http\Controllers\Complaint;

use App\ComplaintService;
use App\Customer;
use App\Service;
use App\ServiceCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Webpatser\Uuid\Uuid;

class ComplaintServiceController extends Controller
{
    public function index() {
        $services = Service::where('tenantId', Auth::user()->tenantId)->paginate(6);
        return view('complaint.service.complaint_service_index', compact('services'));
    }

    public function showService($id, $currentNodeId) {
        if($currentNodeId == 0) {
            $service = Service::findOrFail($id);
            $serviceCategories = ServiceCategory::where('serviceId', $service->systemId)->where('parent_id', null)->get();
            $selectCustomers = Customer::where('tenantId', Auth::user()->tenantId)->get()->pluck('full_information', 'systemId');
            return view('complaint.service.complaint_service_show', compact('service', 'serviceCategories', 'selectCustomers'));
        } else {
            $service = Service::findOrFail($id);
            $serviceCategories = ServiceCategory::where('parent_id', $currentNodeId)->get();
            $currentParentNode = ServiceCategory::findOrFail($currentNodeId);
            $selectCustomers = Customer::where('tenantId', Auth::user()->tenantId)->get()->pluck('full_information', 'systemId');
            return view('complaint.service.complaint_service_show', compact('service', 'serviceCategories', 'currentParentNode', 'selectCustomers'));
        }
    }

    public function store(Request $request) {
        $rules = [
            'customer_complaint' => 'required',
            'customer_rating' => 'required'
        ];
        $messages = [
            'customer_complaint.required' => 'please enter customer\'s complaint',
            'customer_rating' => 'please choose customer\'s satisfaction'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        ComplaintService::create([
            'systemId' => Uuid::generate(4),
            'customer_complaint' => $request->customer_complaint,
            'customer_rating' => $request->customer_rating,
            'is_need_call' => $request->is_need_call,
            'is_urgent' => $request->is_urgent,
            'customerId' => $request->customerId,
            'serviceId' => $request->serviceId,
            'serviceCategoryId' => $request->serviceCategoryId,
            'tenantId' => $request->tenantId
        ]);
        return redirect()->back()->with('status', 'New complaint has been added, please check your complaint service list');
    }
}
