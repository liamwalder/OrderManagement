<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

/**
 * Class OrderRequest
 * @package App\Http\Requests
 */
class OrderRequest extends FormRequest
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
     * @return array
     */
    public function rules(Request $request)
    {
        $rules = [
            'order.address_id' => 'required',
            'order.customer_id' => 'required',
            'order.products' => 'required'
        ];

        return $rules;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'order.address_id.required' => 'Please select an address.',
            'order.customer_id.required' => 'Please select a customer.',
            'order.products.required' => 'There must be at least one product to place an order.'
        ];
    }
}
