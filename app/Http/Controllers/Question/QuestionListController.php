<?php

namespace App\Http\Controllers\Question;

use App\Customer;
use App\Http\Requests\Question\QuestionRequest;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class QuestionListController extends Controller
{
    public function index() {
        $questions = Question::where('tenantId', Auth::user()->tenantId)->orderBy('created_at', 'desc')->get();
        return view('question.list.question_list_index', compact('questions'));
    }

    public function edit($id) {
        $question = Question::findOrFail($id);
        $selectCustomers =  Customer::where('tenantId', Auth::user()->tenantId)->orderBy('created_at', 'desc')->get()->pluck('full_information', 'systemId');
        return view('question.list.question_list_edit', compact('question', 'selectCustomers'));
    }

    public function update(QuestionRequest $request, $id) {
        $question = Question::findOrFail($id);
        $question->update($request->all());
        return redirect('question_list')->with('status', 'Question has been updated!');
    }

    public function show($id) {
        $question = Question::findOrFail($id);
        return view('question.list.question_list_show', compact('question'));
    }

    public function deleteQuestion(Request $request) {
        $question = Question::findOrFail($request->question_id);
        $question->delete();
        return redirect('question_list')->with(['status' => 'Question has been deleted']);
    }

    public function answerQuestion(Request $request, $id) {
        $question = Question::findOrFail($id);
        $question->update([
            'answer' => $request->answer,
            'is_answered' => 1
        ]);
        return redirect()->back()->with(['status' => 'Question has been answered']);
    }

    public function updateAnswer(Request $request, $id) {
        $question = Question::findOrFail($id);
        $question->update([
            'answer' => $request->answer,
            'is_answered' => 1
        ]);
        return redirect()->back()->with(['status' => 'Answer has been updated']);
    }

    public function deleteAnswer(Request $request) {
        $question = Question::findOrFail($request->question_id);
        $question->update([
            'answer' => null,
            'is_answered' => 0
        ]);
        return redirect()->back()->with(['status' => 'Answer has been deleted']);
    }
}
