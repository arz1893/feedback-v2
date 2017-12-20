<?php

namespace App\Http\Controllers\Question;

use App\Customer;
use App\Http\Requests\Question\QuestionRequest;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class QuestionController extends Controller
{
    public function index() {
        $questions = Question::where('tenantId', Auth::user()->tenantId)->get();
        return view('question.question_index', compact('questions'));
    }

    public function create() {
        $selectCustomers = Customer::where('tenantId', Auth::user()->tenantId)->pluck('name', 'systemId');
        return view('question.add_question', compact('selectCustomers'));
    }

    public function store(QuestionRequest $request) {
        Question::create([
            'systemId' => Uuid::generate(4),
            'customerId' => $request->customerId,
            'question' => $request->question,
            'is_need_call' => ($request->is_need_call == 'on' ? 1:0),
            'tenantId' => Auth::user()->tenantId
        ]);
        return redirect()->route('question.index')->with(['status' => 'Question has been added']);
    }

    public function edit(Question $question) {
        $selectCustomers = Customer::where('tenantId', Auth::user()->tenantId)->orderBy('name', 'asc')->pluck('name', 'systemId');
        return view('question.edit_question', compact('question', 'selectCustomers'));
    }

    public function update(QuestionRequest $request, Question $question) {
        $question->update($request->all());
        return redirect('question')->with('status', 'A new question has been added');
    }
}
