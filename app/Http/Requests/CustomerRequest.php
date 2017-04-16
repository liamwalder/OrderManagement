<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

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
     * @return array
     */
    public function rules(Request $request)
    {
        $rules = [
            'customer.firstname' => 'required',
            'customer.surname' => 'required',
            'customer.email' => 'email|required|unique:customers,email',
            'customer.phone' => 'required'
        ];

        if ($this->method() == 'PATCH') {
            $rules['customer.email'] = 'email|required|unique:customers,id,'.$request->segment(3);
        }

        return $rules;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'customer.firstname.required' => 'Firstname is a required field.',
            'customer.surname.required' => 'Surname is a required field.',
            'customer.phone.required' => 'Phone is a required field',
            'customer.email.required' => 'Email is a required field.',
            'customer.email.unique' => 'This email address has already been taken.',
            'customer.email.email' => 'Email address is not the correct format.'
        ];
    }
}
