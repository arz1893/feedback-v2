<?php

namespace App\Http\Controllers\Complaint;

use App\ComplaintProduct;
use App\ComplaintProductReply;
use App\Http\Controllers\Controller;
use App\Http\Resources\ComplaintProductReplyCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class ComplaintProductReplyController extends Controller
{
    public function store(Request $request) {
        ComplaintProductReply::create([
            'systemId' => Uuid::generate(4),
            'reply_content' => $request->reply_content,
            'customerId' => $request->customerId,
            'complaintProductId' => $request->complaintProductId,
            'syscreator' => Auth::user()->systemId
        ]);

        $complaintProduct = ComplaintProduct::findOrFail($request->complaintProductId);
        $complaintProduct->is_answered = 1;
        $complaintProduct->update();

        return redirect()->back()->with(['status' => 'A new complaint has been added']);
    }

    public function getComplaintProductReplies(Request $request, $complaint_product_id) {
        $complaintProductReplies = ComplaintProductReply::where('complaintProductId', $complaint_product_id)->orderBy('created_at', 'asc')->get();
        if(count($complaintProductReplies) > 0) {
            return new ComplaintProductReplyCollection($complaintProductReplies);
        } else {
            return null;
        }
    }

    public function postReply(Request $request, $complaintProductId) {
        $complaintProductReply = ComplaintProductReply::create([
            'systemId' => Uuid::generate(4),
            'reply_content' => $request->reply_content,
            'customerId' => $request->customerId,
            'complaintProductId' => $complaintProductId,
            'syscreator' => $request->creatorId
        ]);

        if($complaintProductReply) {
            $complaintProduct = ComplaintProduct::findOrFail($request->complaintProductId);
            $complaintProduct->is_answered = 1;
            $complaintProduct->update();

            return ['status' => true];
        } else {
            return ['status' => false];
        }
    }

    public function deleteReply(Request $request) {
        $complaintProductReply = ComplaintProductReply::findOrFail($request->replyId);
        $complaintProduct = ComplaintProduct::findOrFail($complaintProductReply->complaintProductId);

        if(count($complaintProduct->complaint_product_replies) == 0) {
            $complaintProduct->is_answered = 0;
        }

        $is_deleted = $complaintProductReply->delete();
        if($is_deleted) {
            return ['status' => true];
        } else {
            return ['status' => false];
        }
    }
}
