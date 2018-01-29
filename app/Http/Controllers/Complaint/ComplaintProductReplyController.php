<?php

namespace App\Http\Controllers\Complaint;

use App\ComplaintProduct;
use App\ComplaintProductReply;
use App\Http\Controllers\Controller;
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
}
