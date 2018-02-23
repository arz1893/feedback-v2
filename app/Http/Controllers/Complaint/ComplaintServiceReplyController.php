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

    public function getComplaintServiceReplies(Request $request, $complaint_service_id) {
        $complaintServiceReplies = ComplaintServiceReply::where('complaintServiceId', $complaint_service_id)->orderBy('created_at', 'asc')->get();
        if(count($complaintServiceReplies) > 0) {
            return new ComplaintServiceReplyCollection($complaintServiceReplies);
        } else {
            return null;
        }
    }

    public function postReply(Request $request, $complaint_service_id) {
        $complaintServiceReply = ComplaintServiceReply::create([
            'systemId' => Uuid::generate(4),
            'reply_content' => $request->reply_content,
            'customerId' => $request->customerId,
            'complaintServiceId' => $complaint_service_id,
            'syscreator' => $request->creatorId
        ]);

        if($complaintServiceReply) {
            $complaintService = ComplaintService::findOrFail($request->complaintServiceId);
            $complaintService->is_answered = 1;
            $complaintService->update();

            return ['status' => true];
        } else {
            return  ['status' => false];
        }
    }

    public function deleteReply(Request $request) {
        $complaintServiceReply = ComplaintServiceReply::findOrFail($request->replyId);
        $complaintService = ComplaintService::findOrFail($complaintServiceReply->complaintServiceId);

        if(count($complaintService->complaint_service_replies) == 0) {
            $complaintService->is_answered = 0;
        }

        $is_deleted = $complaintServiceReply->delete();
        if($is_deleted) {
            return ['status' => true];
        } else {
            return ['status' => false];
        }
    }
}
