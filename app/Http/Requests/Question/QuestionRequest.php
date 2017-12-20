<?php

namespace App\Http\Requests\Question;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customerId' => 'required',
            'question' => 'required',
        ];

    }

    public function messages()
    {
        return [
            'customerId.required' => 'Please select or add customer first',
            'question.required' => 'Please enter customer\'s question'
        ];
    }
}
