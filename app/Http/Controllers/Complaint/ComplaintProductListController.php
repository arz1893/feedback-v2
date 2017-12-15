<?php

namespace App\Http\Controllers\Complaint;

use App\ComplaintProduct;
use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ComplaintProductListController extends Controller
{
    public function index() {
        $complaintProducts = ComplaintProduct::where('tenantId', Auth::user()->tenantId)->get();
        return view('complaint.product.list.complaint_product_list_index', compact('complaintProducts'));
    }

    public function edit($id) {
        $complaintProduct = ComplaintProduct::findOrfail($id);
        $selectCustomers =  Customer::where('tenantId', Auth::user()->tenantId)->pluck('name','systemId');
        return view('complaint.product.list.complaint_product_list_edit', compact('complaintProduct', 'selectCustomers'));
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

        $complaintProduct = ComplaintProduct::findOrFail($id);
        $complaintProduct->update($request->all());
        return redirect('complaint_product_list')->with('status', 'Complaint has been updated');
    }

    public function deleteComplaintProduct(Request $request) {
        $complaintProduct = ComplaintProduct::findOrFail($request->complaint_id);
        $complaintProduct->delete();
        return redirect('complaint_product_list')->with('status', 'Complaint has been deleted');
    }
}
