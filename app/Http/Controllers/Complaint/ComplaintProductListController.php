<?php

namespace App\Http\Controllers\Complaint;

use App\ComplaintProduct;
use App\Customer;
use App\Http\Requests\Complaint\ComplaintProductRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ComplaintProductListController extends Controller
{
    public function index() {
        $complaintProducts = ComplaintProduct::where('tenantId', Auth::user()->tenantId)->orderBy('created_at', 'desc')->get();
        return view('complaint.product.list.complaint_product_list_index', compact('complaintProducts'));
    }

    public function edit($id) {
        $complaintProduct = ComplaintProduct::findOrfail($id);
        $selectCustomers =  Customer::where('tenantId', Auth::user()->tenantId)->orderBy('created_at', 'desc')->get()->pluck('full_information', 'systemId');
        return view('complaint.product.list.complaint_product_list_edit', compact('complaintProduct', 'selectCustomers'));
    }

    public function show($id) {
        $complaintProduct = ComplaintProduct::findOrFail($id);
        return view('complaint.product.list.complaint_product_list_show', compact('complaintProduct'));
    }

    public function update(ComplaintProductRequest $request, $id) {

        $complaintProduct = ComplaintProduct::findOrFail($id);
        $file_attachment = $request->file('attachment');
        if($file_attachment != null) {
            $filename = $id . '-' . $file_attachment->getClientOriginalName();
            if(!file_exists(public_path('attachment/' . Auth::user()->tenant->email . '/complaint_product/' . $complaintProduct->productId))) {
                mkdir(public_path('attachment/' . Auth::user()->tenant->email . '/complaint_product/' . $complaintProduct->productId), 0777, true);
            }
            if($complaintProduct->attachment != null) {
                unlink(public_path($complaintProduct->attachment));
            }
            $file_attachment->move(public_path('attachment/' . Auth::user()->tenant->email . '/complaint_product/' . $complaintProduct->productId . '/'), $filename);
            $complaintProduct->update([
                'customerId' => $request->customerId,
                'customer_rating' => $request->customer_rating,
                'customer_complaint' => $request->customer_complaint,
                'is_need_call' => $request->is_need_call,
                'is_urgent' => $request->is_urgent,
                'attachment' => 'attachment/' . Auth::user()->tenant->email . '/complaint_product/' . $complaintProduct->productId . '/' . $filename
            ]);
        } else {
            $complaintProduct->update([
                'customerId' => $request->customerId,
                'customer_rating' => $request->customer_rating,
                'customer_complaint' => $request->customer_complaint,
                'is_need_call' => $request->is_need_call,
                'is_urgent' => $request->is_urgent
            ]);
        }
        return redirect()->route('complaint_product_list.show', $id)->with('status', 'Complaint has been updated');
    }

    public function deleteComplaintProduct(Request $request) {
        $complaintProduct = ComplaintProduct::findOrFail($request->complaint_id);
        if($complaintProduct->attachment != null) {
            unlink(public_path($complaintProduct->attachment));
        }
        $complaintProduct->delete();
        return redirect('complaint_product_list')->with('status', 'Complaint has been deleted');
    }
}
