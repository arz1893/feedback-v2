<?php

namespace App\Http\Controllers\Complaint;

use App\ComplaintService;
use App\Customer;
use App\Http\Requests\Complaint\ComplaintServiceRequest;
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
        $services = Service::where('tenantId', Auth::user()->tenantId)->orderBy('name', 'asc')->paginate(6);
        return view('complaint.service.complaint_service_index', compact('services'));
    }

    public function showService($id, $currentNodeId) {
        if($currentNodeId == 0) {
            $service = Service::findOrFail($id);
            $serviceCategories = ServiceCategory::where('serviceId', $service->systemId)->where('parent_id', null)->get();
            $selectCustomers = Customer::where('tenantId', Auth::user()->tenantId)->orderBy('created_at', 'desc')->get()->pluck('full_information', 'systemId');
            return view('complaint.service.complaint_service_show', compact('service', 'serviceCategories', 'selectCustomers'));
        } else {
            $service = Service::findOrFail($id);
            $serviceCategories = ServiceCategory::where('parent_id', $currentNodeId)->get();
            $currentParentNode = ServiceCategory::findOrFail($currentNodeId);
            $selectCustomers = Customer::where('tenantId', Auth::user()->tenantId)->orderBy('created_at', 'desc')->get()->pluck('full_information', 'systemId');
            return view('complaint.service.complaint_service_show', compact('service', 'serviceCategories', 'currentParentNode', 'selectCustomers'));
        }
    }

    public function store(ComplaintServiceRequest $request) {

        $file_attachment = $request->file('attachment');
        $id = Uuid::generate(4);
        if(!is_null($file_attachment)) {
            $filename = $id . '-' . $file_attachment->getClientOriginalName();
            if(!file_exists(public_path('attachment/' . Auth::user()->tenant->email . '/complaint_service/' . $request->serviceId))) {
                mkdir(public_path('attachment/' . Auth::user()->tenant->email . '/complaint_service/' . $request->serviceId), 0777, true);
            }
            $file_attachment->move(public_path('attachment/' . Auth::user()->tenant->email . '/complaint_service/' . $request->serviceId . '/'), $filename);
            ComplaintService::create([
                'systemId' => $id,
                'customer_complaint' => $request->customer_complaint,
                'customer_rating' => $request->customer_rating,
                'is_need_call' => $request->is_need_call,
                'is_urgent' => $request->is_urgent,
                'customerId' => $request->customerId,
                'serviceId' => $request->serviceId,
                'serviceCategoryId' => $request->serviceCategoryId,
                'tenantId' => $request->tenantId,
                'attachment' => 'attachment/' . Auth::user()->tenant->email . '/complaint_service/' . $request->serviceId . '/' . $filename,
                'syscreator' => Auth::user()->systemId
            ]);
        } else {
            ComplaintService::create([
                'systemId' => $id,
                'customer_complaint' => $request->customer_complaint,
                'customer_rating' => $request->customer_rating,
                'is_need_call' => $request->is_need_call,
                'is_urgent' => $request->is_urgent,
                'customerId' => $request->customerId,
                'serviceId' => $request->serviceId,
                'serviceCategoryId' => $request->serviceCategoryId,
                'tenantId' => $request->tenantId,
                'syscreator' => Auth::user()->systemId
            ]);
        }
        return redirect()->back()->with('status', 'New complaint has been added, please check your complaint service list');
    }
}
