<?php

namespace App\Http\Controllers\Suggestion;

use App\Customer;
use App\SuggestionProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SuggestionProductListController extends Controller
{
    public function index() {
        $suggestionProducts = SuggestionProduct::where('tenantId', Auth::user()->tenantId)->orderBy('created_at', 'desc')->get();
        return view('suggestion.product.list.suggestion_product_list_index', compact('suggestionProducts'));
    }

    public function edit($id) {
        $suggestionProduct = SuggestionProduct::findOrFail($id);
        $selectCustomers = Customer::where('tenantId', Auth::user()->tenantId)->get()->pluck('full_information', 'systemId');
        return view('suggestion.product.list.suggestion_product_list_edit', compact('suggestionProduct', 'selectCustomers'));
    }

    public function update(Request $request, $id) {
        $rules = [
            'customer_suggestion' => 'required'
        ];
        $messages = [
            'customer_suggestion.required' => 'please enter customer\'s suggestion'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $suggestionProduct = SuggestionProduct::findOrFail($id);
        $suggestionProduct->update($request->all());
        return redirect('suggestion_product_list')->with('status', 'Suggestion has been updated');
    }

    public function deleteSuggestionProduct(Request $request) {
        $suggestionProduct = SuggestionProduct::findOrFail($request->suggestion_id);
        $suggestionProduct->delete();
        return redirect('suggestion_product_list')->with('status', 'Suggestion has been deleted');
    }
}
