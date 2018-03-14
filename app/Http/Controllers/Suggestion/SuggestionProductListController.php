<?php

namespace App\Http\Controllers\Suggestion;

use App\Customer;
use App\Http\Requests\Suggestion\SuggestionProductRequest;
use App\SuggestionProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SuggestionProductListController extends Controller
{
    public function index() {
        $selectCustomers = Customer::where('tenantId', Auth::user()->tenantId)->get();
        return view('suggestion.product.list.suggestion_product_list_index', compact('selectCustomers'));
    }

    public function edit($id) {
        $suggestionProduct = SuggestionProduct::findOrFail($id);
        $selectCustomers = Customer::where('tenantId', Auth::user()->tenantId)->orderBy('created_at', 'desc')->get()->pluck('full_information', 'systemId');
        return view('suggestion.product.list.suggestion_product_list_edit', compact('suggestionProduct', 'selectCustomers'));
    }

    public function show($id) {
        $suggestionProduct = SuggestionProduct::findOrFail($id);
        return view('suggestion.product.list.suggestion_product_list_show', compact('suggestionProduct'));
    }

    public function update(SuggestionProductRequest $request, $id) {
        $suggestionProduct = SuggestionProduct::findOrFail($id);
        $file_attachment = $request->file('attachment');
        if($file_attachment != null) {
            $filename = $id . '-' . $file_attachment->getClientOriginalName();
            if(!file_exists(public_path('attachment/' . Auth::user()->tenant->email . '/suggestion_product/' . $suggestionProduct->productId))) {
                mkdir(public_path('attachment/' . Auth::user()->tenant->email . '/suggestion_product/' . $suggestionProduct->productId), 0777, true);
            }
            if($suggestionProduct->attachment != null) {
                unlink(public_path($suggestionProduct->attachment));
            }
            $file_attachment->move(public_path('attachment/' . Auth::user()->tenant->email . '/suggestion_product/' . $suggestionProduct->productId . '/'), $filename);
            $suggestionProduct->update([
                'customerId' => $request->customerId,
                'customer_suggestion' => $request->customer_suggestion,
                'attachment' => 'attachment/' . Auth::user()->tenant->email . '/suggestion_product/' . $suggestionProduct->productId . '/' . $filename
            ]);
        } else {
            $suggestionProduct->update([
                'customerId' => $request->customerId,
                'customer_suggestion' => $request->customer_suggestion,
            ]);
        }
        return redirect('suggestion_product_list')->with('status', 'Suggestion has been updated');
    }

    public function deleteSuggestionProduct(Request $request) {
        $suggestionProduct = SuggestionProduct::findOrFail($request->suggestion_id);
        if($suggestionProduct->attachment != null) {
            unlink(public_path($suggestionProduct->attachment));
        }
        $suggestionProduct->delete();
        return redirect('suggestion_product_list')->with('status', 'Suggestion has been deleted');
    }

    public function changeAttachment(Request $request, $id) {
        $suggestionProduct = SuggestionProduct::findOrFail($id);
        $file_attachment = $request->file('attachment');
        $filename = $id . '-' . $file_attachment->getClientOriginalName();

        if($suggestionProduct->attachment != null) {
            unlink(public_path($suggestionProduct->attachment));
            $file_attachment->move(public_path('attachment/' . Auth::user()->tenant->email . '/suggestion_product/' . $suggestionProduct->productId . '/'), $filename);
            $suggestionProduct->update([
                'attachment' => 'attachment/' . Auth::user()->tenant->email . '/suggestion_product/' . $suggestionProduct->productId . '/' . $filename
            ]);
            return redirect()->back()->with(['status' => 'Attachment has been updated']);
        } else {
            $file_attachment->move(public_path('attachment/' . Auth::user()->tenant->email . '/suggestion_product/' . $suggestionProduct->productId . '/'), $filename);
            $suggestionProduct->update([
                'attachment' => 'attachment/' . Auth::user()->tenant->email . '/suggestion_product/' . $suggestionProduct->productId . '/' . $filename
            ]);
            return redirect()->back()->with(['status' => 'Attachment has been updated']);
        }
    }

    public function deleteAttachment(Request $request) {
        $suggestionProduct = SuggestionProduct::findOrFail($request->suggestionProductId);

        if(file_exists(public_path($suggestionProduct->attachment))) {
            unlink(public_path($suggestionProduct->attachment));
            $suggestionProduct->update([
                'attachment' => null
            ]);
            return redirect()->back()->with(['status' => 'Attachment has been deleted']);
        } else {
            $suggestionProduct->update([
                'attachment' => null
            ]);
            return redirect()->back()->with(['status' => 'Attachment has been deleted']);
        }
    }
}
