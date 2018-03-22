<?php

namespace App\Http\Controllers\Report\Suggestion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuggestionReportController extends Controller
{
    public function index() {
        return view('report.suggestion.suggestion_report_index');
    }
}
