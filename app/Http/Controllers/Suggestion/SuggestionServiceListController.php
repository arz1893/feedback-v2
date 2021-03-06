<?php

namespace App\Http\Controllers\Suggestion;

use App\Customer;
use App\Http\Requests\Suggestion\SuggestionServiceRequest;
use App\Service;
use App\SuggestionService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SuggestionServiceListController extends Controller
{
    public function index() {
//        $selectCustomers = Customer::where('tenantId', Auth::user()->tenantId)->orderBy('name', 'asc')->get();
        $selectServices = Service::where('tenantId', Auth::user()->tenantId)->orderBy('created_at', 'desc')->pluck('name', 'systemId');
        return view('suggestion.service.list.suggestion_service_list_index', compact('selectServices'));
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
        if($suggestionService->attachment != null) {
            unlink(public_path($suggestionService->attachment));
        }
        $suggestionService->delete();
        return redirect('suggestion_service_list')->with('status', 'Suggestion has been deleted');
    }

    public function changeAttachment(Request $request, $id) {
        $suggestionService = SuggestionService::findOrFail($id);
        $file_attachment = $request->file('attachment');
        $filename = $id . '-' . $file_attachment->getClientOriginalName();

        if($suggestionService->attachment != null) {
            unlink(public_path($suggestionService->attachment));
            $file_attachment->move(public_path('attachment/' . Auth::user()->tenant->email . '/suggestion_service/' . $suggestionService->serviceId . '/'), $filename);
            $suggestionService->update([
                'attachment' => 'attachment/' . Auth::user()->tenant->email . '/suggestion_service/' . $suggestionService->serviceId . '/' . $filename
            ]);
            return redirect()->back()->with(['status' => 'Attachment has been updated']);
        } else {
            $file_attachment->move(public_path('attachment/' . Auth::user()->tenant->email . '/suggestion_service/' . $suggestionService->serviceId . '/'), $filename);
            $suggestionService->update([
                'attachment' => 'attachment/' . Auth::user()->tenant->email . '/suggestion_service/' . $suggestionService->serviceId . '/' . $filename
            ]);
            return redirect()->back()->with(['status' => 'Attachment has been updated']);
        }
    }

    public function deleteAttachment(Request $request) {
        $suggestionService = SuggestionService::findOrFail($request->suggestionServiceId);

        if(file_exists(public_path($suggestionService->attachment))) {
            unlink(public_path($suggestionService->attachment));
            $suggestionService->update([
                'attachment' => null
            ]);
            return redirect()->back()->with(['status' => 'Attachment has been deleted!']);
        } else {
            $suggestionService->update([
                'attachment' => null
            ]);
            return redirect()->back()->with(['status' => 'Attachment has been deleted!']);
        }
    }
}
