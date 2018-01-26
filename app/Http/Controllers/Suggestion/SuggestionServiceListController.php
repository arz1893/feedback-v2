<?php

namespace App\Http\Controllers\Suggestion;

use App\Customer;
use App\Http\Requests\Suggestion\SuggestionServiceRequest;
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

    public function show($id) {
        $suggestionService = SuggestionService::findOrFail($id);
        return view('suggestion.service.list.suggestion_service_list_show', compact('suggestionService'));
    }

    public function update(SuggestionServiceRequest $request, $id) {
        $suggestionService = SuggestionService::findOrFail($id);
        $file_attachment = $request->file('attachment');
        if($file_attachment != null) {
            $filename = $id . '-' . $file_attachment->getClientOriginalName();
            if(!file_exists(public_path('attachment/' . Auth::user()->tenant->email . '/suggestion_service/' . $suggestionService->serviceId))) {
                mkdir(public_path('attachment/' . Auth::user()->tenant->email . '/suggestion_service/' . $suggestionService->serviceId), 0777, true);
            }
            if($suggestionService->attachment != null) {
                unlink(public_path($suggestionService->attachment));
            }
            $file_attachment->move(public_path('attachment/' . Auth::user()->tenant->email . '/suggestion_service/' . $suggestionService->serviceId . '/'), $filename);
            $suggestionService->update([
                'customerId' => $request->customerId,
                'customer_suggestion' => $request->customer_suggestion,
                'attachment' => 'attachment/' . Auth::user()->tenant->email . '/suggestion_service/' . $suggestionService->serviceId . '/' . $filename
            ]);
        } else {
            $suggestionService->update([
                'customerId' => $request->customerId,
                'customer_suggestion' => $request->customer_suggestion
            ]);
        }
        return redirect()->route('suggestion_service_list.show', $suggestionService->systemId)->with('status', 'Suggestion has been updated');
    }

    public function deleteSuggestionService(Request $request) {
        $suggestionService = SuggestionService::findOrFail($request->suggestion_id);
        $suggestionService->delete();
        return redirect('suggestion_service_list')->with('status', 'Suggestion has been deleted');
    }
}
