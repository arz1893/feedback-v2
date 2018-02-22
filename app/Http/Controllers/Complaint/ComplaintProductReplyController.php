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

    public function deleteReply(Request $request) {
        $complaintProductReply = ComplaintProductReply::findOrFail($request->id);
        $complaintProductReply->delete();
        return redirect()->back()->with(['status' => 'Reply has been deleted']);
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
        ComplaintProductReply::create([
            'systemId' => Uuid::generate(4),
            'reply_content' => $request->reply_content,
            'customerId' => $request->customerId,
            'complaintProductId' => $complaintProductId,
            'syscreator' => $request->creatorId
        ]);

        $complaintProduct = ComplaintProduct::findOrFail($request->complaintProductId);
        $complaintProduct->is_answered = 1;
        $complaintProduct->update();

        return ['status' => true];
    }
}
