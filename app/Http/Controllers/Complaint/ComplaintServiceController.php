<?php

namespace App\Http\Controllers\Complaint;

use App\ComplaintService;
use App\Customer;
use App\Http\Requests\Complaint\ComplaintServiceRequest;
use App\Http\Resources\ComplaintServiceCollection;
use App\Http\Resources\ServiceCollection;
use App\Service;
use App\ServiceCategory;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Webpatser\Uuid\Uuid;
use App\Http\Resources\ComplaintService as ComplaintServiceResource;

class ComplaintServiceController extends Controller
{
    public function index() {
        $selectTags = Tag::where('recOwner', Auth::user()->tenantId)->orderBy('name', 'asc')->pluck('name', 'systemId');
        $defaultTags = Tag::where('recOwner', Auth::user()->tenantId)->where('defValue', 1)->orderBy('name', 'asc')->pluck('systemId');
        $services = Service::where('tenantId', Auth::user()->tenantId)->orderBy('name', 'asc')->paginate(6);
        return view('complaint.service.complaint_service_index', compact('services', 'selectTags', 'defaultTags'));
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

    public function getComplaintService(Request $request, $complaint_id) {
        $complaintService = ComplaintService::findOrFail($complaint_id);
        return new ComplaintServiceResource($complaintService);
    }

    public function getAllComplaintService(Request $request, $tenantId) {
        $complaintServices = ComplaintService::where('tenantId', $tenantId)->orderBy('created_at', 'desc')->paginate(20);
        return new ComplaintServiceCollection($complaintServices);
    }

    public function filterByDate(Request $request, $tenantId, $from, $to) {
        if($from == $to) {
            $filteredComplaintServices = ComplaintService::where('tenantId', $tenantId)->whereDate('created_at', '=', $from)->orderBy('created_at', 'desc')->paginate(20);
            return new ComplaintServiceCollection($filteredComplaintServices);
        } else if($from > $to) {
            $filteredComplaintServices = ComplaintService::where('tenantId', $tenantId)->whereBetween('created_at', [$to, $from])->orderBy('created_at', 'desc')->paginate(20);
            return new ComplaintServiceCollection($filteredComplaintServices);
        } else {
            $filteredComplaintServices = ComplaintService::where('tenantId', $tenantId)->whereBetween('created_at', [$from, $to])->orderBy('created_at', 'desc')->paginate(20);
            return new ComplaintServiceCollection($filteredComplaintServices);
        }
    }

    public function filterByCustomer(Request $request, $tenantId, $customerId) {
        if($customerId == -1) {
            $filteredComplaintServices = ComplaintService::where('tenantId', $tenantId)->where('customerId', null)->paginate(10);
            return new ComplaintServiceCollection($filteredComplaintServices);
        } else {
            $filteredComplaintServices = ComplaintService::where('tenantId', $tenantId)->where('customerId', $customerId)->paginate(10);
            return new ComplaintServiceCollection($filteredComplaintServices);
        }
    }
}
