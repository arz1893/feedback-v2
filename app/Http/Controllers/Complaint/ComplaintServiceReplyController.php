<?php

namespace App\Http\Controllers\Complaint;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ComplaintServiceReplyController extends Controller
{
    public function store(Request $request) {
        dd($request->all());
    }
}
