<?php

namespace App\Http\Requests\Suggestion;

use Illuminate\Foundation\Http\FormRequest;

class SuggestionServiceRequest extends FormRequest
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
            'customer_suggestion' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'customer_suggestion.required' => 'please enter customer\'s suggestion'
        ];
    }
}
