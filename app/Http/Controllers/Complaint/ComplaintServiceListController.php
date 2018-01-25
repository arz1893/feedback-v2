<?php

namespace App\Http\Controllers\Complaint;

use App\ComplaintService;
use App\Customer;
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

    public function update(Request $request, $id) {
        $rules = [
            'customer_complaint' => 'required'
        ];
        $messages = [
            'customer_complaint.required' => 'please enter customer\'s complaint'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $complaintService = ComplaintService::findOrFail($id);
        $complaintService->update($request->all());
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
