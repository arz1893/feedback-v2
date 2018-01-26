<?php

namespace App\Http\Controllers\Complaint;

use App\ComplaintService;
use App\Customer;
use App\Http\Requests\Complaint\ComplaintServiceRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ComplaintServiceListController extends Controller
{
    public function index() {
        $complaintServices = ComplaintService::where('tenantId', Auth::user()->tenantId)->orderBy('created_at', 'desc')->get();
        return view('complaint.service.list.complaint_service_list_index', compact('complaintServices'));
    }

    public function edit($id) {
        $complaintService = ComplaintService::findOrFail($id);
        $selectCustomers = Customer::where('tenantId', Auth::user()->tenantId)->orderBy('created_at', 'desc')->get()->pluck('full_information', 'systemId');
        return view('complaint.service.list.complaint_service_list_edit', compact('complaintService', 'selectCustomers'));
    }

    public function show($id) {
        $complaintService = ComplaintService::findOrFail($id);
        return view('complaint.service.list.complaint_service_list_show', compact('complaintService'));
    }

    public function update(ComplaintServiceRequest $request, $id) {
        $complaintService = ComplaintService::findOrFail($id);
        $file_attachment = $request->file('attachment');
        if($file_attachment != null) {
            $filename = $id . '-' . $file_attachment->getClientOriginalName();
            if(!file_exists(public_path('attachment/' . Auth::user()->tenant->email . '/complaint_service/' . $complaintService->serviceId))) {
                mkdir(public_path('attachment/' . Auth::user()->tenant->email . '/complaint_service/' . $complaintService->serviceId), 0777, true);
            }
            if($complaintService->attachment != null) {
                unlink(public_path($complaintService->attachment));
            }
            $file_attachment->move(public_path('attachment/' . Auth::user()->tenant->email . '/complaint_service/' . $complaintService->serviceId . '/'), $filename);
            $complaintService->update([
                'customerId' => $request->customerId,
                'customer_rating' => $request->customer_rating,
                'customer_complaint' => $request->customer_complaint,
                'is_need_call' => $request->is_need_call,
                'is_urgent' => $request->is_urgent,
                'attachment' => 'attachment/' . Auth::user()->tenant->email . '/complaint_service/' . $complaintService->serviceId . '/' . $filename
            ]);
        } else {
            $complaintService->update([
                'customerId' => $request->customerId,
                'customer_rating' => $request->customer_rating,
                'customer_complaint' => $request->customer_complaint,
                'is_need_call' => $request->is_need_call,
                'is_urgent' => $request->is_urgent
            ]);
        }

        return redirect()->route('complaint_service_list.show', $id)->with('status', 'Complaint has been updated');
    }

    public function deleteComplaintService(Request $request) {
        $complaintService = ComplaintService::findOrFail($request->complaint_id);
        if($complaintService->attachment != null) {
            unlink(public_path($complaintService->attachment));
        }
        $complaintService->delete();
        return redirect('complaint_service_list')->with('status', 'Complaint has been deleted');
    }
}
