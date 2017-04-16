<?php

namespace App\Http\Requests;

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
            'product.name' => 'required',
            'product.price' => 'required'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'product.name.required' => 'Name is a required field.',
            'product.price.required' => 'Price is a required field.',
        ];
    }
}
