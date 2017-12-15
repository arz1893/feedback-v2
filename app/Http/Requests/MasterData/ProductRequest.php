<?php

namespace App\Http\Requests\MasterData;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'metric' => 'required',
            'price' => 'required|numeric',
            'description' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter your product name',
            'metric.required' => 'Please enter product\'s metric',
            'price.required' => 'Please enter product\'s price',
            'price.numeric' => 'Price must be numeric',
            'description.required' => 'Please enter your product description',
        ];
    }
}
