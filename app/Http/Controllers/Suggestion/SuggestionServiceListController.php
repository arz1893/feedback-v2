<?php

namespace App\Http\Controllers\Suggestion;

use App\Customer;
use App\SuggestionService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SuggestionServiceListController extends Controller
{
    public function index() {
        $suggestionServices = SuggestionService::where('tenantId', Auth::user()->tenantId)->orderBy('created_at', 'desc')->get();
        return view('suggestion.service.list.suggestion_service_list_index', compact('suggestionServices'));
    }

    public function edit($id) {
        $suggestionService = SuggestionService::findOrFail($id);
        $selectCustomers = Customer::where('tenantId', Auth::user()->tenantId)->orderBy('created_at', 'desc')->get()->pluck('full_information', 'systemId');
        return view('suggestion.service.list.suggestion_service_list_edit', compact('suggestionService', 'selectCustomers'));
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

        $suggestionService = SuggestionService::findOrFail($id);
        $suggestionService->update($request->all());
        return redirect('suggestion_service_list')->with('status', 'Suggestion has been updated');
    }

    public function deleteSuggestionService(Request $request) {
        $suggestionService = SuggestionService::findOrFail($request->suggestion_id);
        $suggestionService->delete();
        return redirect('suggestion_service_list')->with('status', 'Suggestion has been deleted');
    }
}
