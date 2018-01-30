<?php

namespace App\Http\Controllers\Complaint;

use App\ComplaintService;
use App\ComplaintServiceReply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class ComplaintServiceReplyController extends Controller
{
    public function store(Request $request) {
        ComplaintServiceReply::create([
            'systemId' => Uuid::generate(4),
            'reply_content' => $request->reply_content,
            'customerId' => $request->customerId,
            'complaintServiceId' => $request->complaintServiceId,
            'syscreator' => Auth::user()->systemId
        ]);

        $complaintService = ComplaintService::findOrFail($request->complaintServiceId);
        $complaintService->is_answered = 1;
        $complaintService->update();

        return redirect()->back()->with(['status' => 'complaint has been replied']);
    }
}
