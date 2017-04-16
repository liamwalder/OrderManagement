<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

/**
 * Class AddressRequest
 * @package App\Http\Requests
 */
class AddressRequest extends FormRequest
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
            'address.address_1' => 'required',
            'address.town' => 'required',
            'address.county' => 'required',
            'address.postcode' => 'required',
        ];

        return $rules;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'address.address_1.required' => 'Address line 1 is a required field.',
            'address.town.required' => 'Town is a required field.',
            'address.county.required' => 'County is a required field.',
            'address.postcode.required' => 'Postcode is a required field'
        ];
    }
}
