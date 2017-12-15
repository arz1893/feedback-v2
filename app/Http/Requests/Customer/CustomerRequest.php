<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'name' => 'required',
            'gender' => 'required',
            'phone' => 'required|min:10'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'please enter customer\'s name',
            'gender.required' => 'gender not yet selected',
            'phone.required' => 'please enter customer\'s phone number',
            'phone.min:10' => '10 digits of number are required for phone number'
        ];
    }
}
