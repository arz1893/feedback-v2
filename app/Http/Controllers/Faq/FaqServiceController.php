<?php

namespace App\Http\Controllers\Faq;

use App\FaqService;
use App\Http\Requests\Faq\FaqServiceRequest;
use App\Product;
use App\Service;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class FaqServiceController extends Controller
{
    public function index() {
        $selectTags = Tag::where('recOwner', Auth::user()->tenantId)->orderBy('name', 'asc')->pluck('name', 'systemId');
        $defaultTags = Tag::where('recOwner', Auth::user()->tenantId)->where('defValue', 1)->orderBy('name', 'asc')->pluck('systemId');
        $services = Service::where('tenantId', Auth::user()->tenantId)->orderBy('name', 'asc')->paginate(6);
        return view('faq.service.faq_service_index', compact('services', 'selectTags', 'defaultTags'));
    }

    public function show($id) {
        $service = Service::findOrFail($id);
        $faqServices = FaqService::where('serviceId', $service->systemId)->get();
        return view('faq.service.faq_service_show', compact('service', 'faqServices'));
    }

    public function store(FaqServiceRequest $request) {
        FaqService::create([
            'systemId' => Uuid::generate(4),
            'question' => $request->question,
            'answer' => $request->answer,
            'serviceId' => $request->serviceId
        ]);
        return redirect()->back()->with('status', 'A new FAQ has been added');
    }

    public function edit(FaqService $faqService) {
        return view('faq.service.faq_service_edit', compact('faqService'));
    }

    public function update(FaqServiceRequest $request, FaqService $faqService) {
        $faqService->update($request->all());
        return redirect()->route('faq_service.show', $faqService->serviceId)->with('status', 'FAQ has been udpated');
    }

    public function deleteFaqService(Request $request) {
        $faqService = FaqService::findOrFail($request->faq_service_id);
        $service_id = $faqService->serviceId;
        $faqService->delete();
        return redirect()->route('faq_service.show', $service_id)->with('status', 'FAQ has been deleted');
    }
}
