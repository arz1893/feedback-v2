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
        $questions = Question::where('tenantId', Auth::user()->tenantId)->get();
        return view('question.list.question_list_index', compact('questions'));
    }

    public function edit($id) {
        $question = Question::findOrFail($id);
        $selectCustomers =  Customer::where('tenantId', Auth::user()->tenantId)->get()->pluck('full_information', 'systemId');
        return view('question.list.question_list_edit', compact('question', 'selectCustomers'));
    }

    public function update(QuestionRequest $request, $id) {
        $question = Question::findOrFail($id);
        $question->update($request->all());
        return redirect('question_list')->with('status', 'Question has been updated!');
    }
}
