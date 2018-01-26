<?php

namespace App\Http\Requests\Complaint;

use Illuminate\Foundation\Http\FormRequest;

class ComplaintServiceRequest extends FormRequest
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
            'customer_complaint' => 'required',
            'customer_rating' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'customer_complaint.required' => 'please enter customer\'s complaint',
            'customer_rating' => 'please choose customer\'s satisfaction'
        ];
    }
}
