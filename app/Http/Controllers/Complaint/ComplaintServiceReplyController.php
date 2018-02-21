<?php

namespace App\Http\Controllers\Complaint;

use App\ComplaintService;
use App\ComplaintServiceReply;
use App\Http\Resources\ComplaintServiceReplyCollection;
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

    public function deleteReply(Request $request) {
        $complaintServiceReply = ComplaintServiceReply::findOrFail($request->id);
        $complaintServiceReply->delete();
        return redirect()->back()->with(['status' => 'reply has been deleted']);
    }

    public function getComplaintServiceReplies(Request $request, $complaint_service_id) {
        $complaintServiceReplies = ComplaintServiceReply::where('complaintServiceId', $complaint_service_id)->orderBy('created_at', 'asc')->get();
        if(count($complaintServiceReplies) > 0) {
            return new ComplaintServiceReplyCollection($complaintServiceReplies);
        } else {
            return null;
        }
    }
}
