<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'email' => 'required|email',
            'phone' => 'min:11',
            'usergroupId' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter user\'s name',
            'email.required' => 'Please enter user\'s email address',
            'email.email' => 'Invalid email format',
            'phone.min' => 'Invalid phone number',
            'usergroupId.required' => 'Please select user\'s role'
        ];
    }
}
