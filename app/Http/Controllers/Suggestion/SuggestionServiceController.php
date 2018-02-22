<?php

namespace App\Http\Controllers\Suggestion;

use App\Customer;
use App\Http\Requests\Suggestion\SuggestionServiceRequest;
use App\Service;
use App\ServiceCategory;
use App\SuggestionService;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Webpatser\Uuid\Uuid;
use App\Http\Resources\SuggestionService as SuggestionServiceResource;

class SuggestionServiceController extends Controller
{
    public function index() {
        $selectTags = Tag::where('recOwner', Auth::user()->tenantId)->orderBy('name', 'asc')->pluck('name', 'systemId');
        $services = Service::where('tenantId', Auth::user()->tenantId)->orderBy('name', 'asc')->paginate(6);
        return view('suggestion.service.suggestion_service_index', compact('services', 'selectTags'));
    }

    public function showService($id, $currentNodeId) {
        if($currentNodeId == 0) {
            $service = Service::findOrFail($id);
            $serviceCategories = ServiceCategory::where('serviceID', $service->systemId)->where('parent_id', null)->get();
            $selectCustomers = Customer::where('tenantId', Auth::user()->tenantId)->orderBy('created_at', 'desc')->get()->pluck('full_information', 'systemId');
            return view('suggestion.service.suggestion_service_show', compact('service', 'serviceCategories', 'selectCustomers'));
        } else {
            $service = Service::findOrFail($id);
            $serviceCategories = ServiceCategory::where('parent_id', $currentNodeId)->get();
            $currentParentNode = ServiceCategory::findOrFail($currentNodeId);
            $selectCustomers = Customer::where('tenantId', Auth::user()->tenantId)->orderBy('created_at', 'desc')->get()->pluck('full_information', 'systemId');
            return view('suggestion.service.suggestion_service_show', compact('service', 'serviceCategories', 'currentParentNode', 'selectCustomers'));
        }
    }

    public function store(SuggestionServiceRequest $request) {
        $file_attachment = $request->file('attachment');
        $id = Uuid::generate(4);
        if(!is_null($file_attachment)) {
            $filename = $id . '-' . $file_attachment->getClientOriginalName();
            if(!file_exists(public_path('attachment/' . Auth::user()->tenant->email . '/suggestion_service/' . $request->serviceId))) {
                mkdir(public_path('attachment/' . Auth::user()->tenant->email . '/suggestion_service/' . $request->serviceId), 0777, true);
            }
            $file_attachment->move(public_path('attachment/' . Auth::user()->tenant->email . '/suggestion_service/' . $request->serviceId . '/'), $filename);

            SuggestionService::create([
                'systemId' => $id,
                'customer_suggestion' => $request->customer_suggestion,
                'customerId' => $request->customerId,
                'serviceId' => $request->serviceId,
                'serviceCategoryId' => $request->serviceCategoryId,
                'tenantId' => $request->tenantId,
                'attachment' => 'attachment/' . Auth::user()->tenant->email . '/suggestion_service/' . $request->serviceId . '/' . $filename,
                'syscreator' => Auth::user()->systemId
            ]);
        } else {
            SuggestionService::create([
                'systemId' => $id,
                'customer_suggestion' => $request->customer_suggestion,
                'customerId' => $request->customerId,
                'serviceId' => $request->serviceId,
                'serviceCategoryId' => $request->serviceCategoryId,
                'tenantId' => $request->tenantId,
                'syscreator' => Auth::user()->systemId
            ]);
        }

        return redirect('suggestion_service_list')->with('status', 'A new suggestion has been added');
    }

    public function getSuggestionService(Request $request, $suggestion_service_id) {
        $suggestionService = SuggestionService::findOrFail($suggestion_service_id);
        return new SuggestionServiceResource($suggestionService);
    }
}
