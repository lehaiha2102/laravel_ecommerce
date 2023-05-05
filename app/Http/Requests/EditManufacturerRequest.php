<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditManufacturerRequest extends FormRequest
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
            'name'              => 'required|max:255|string',
            'phone'             => 'required|regex:/^0[0-9]{9}$/|max:255',
            'email'             => 'required|email|max:255|regex:/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/',
            'address'           => 'required|max:255',

        ];
    }

    public function attributes()
    {
        return [
            'name'              => 'Manufacturer name',
            'phone'             => 'Phone number',
            'email'             => 'Email address',
            'address'           => 'Address',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'The :attribute field is required.',
            'name.unique'       => 'The :attribute has already been taken.',
            'name.max'          => 'The :attribute may not be greater than :max characters.',
            'name.string'       => 'The :attribute must be a string.',

            'phone.required'    => 'The :attribute field is required.',
            'phone.unique'      => 'The :attribute has already been taken.',
            'phone.regex'       => 'The :attribute format is invalid.',
            'phone.max'         => 'The :attribute may not be greater than :max characters.',

            'email.required'    => 'The :attribute field is required.',
            'email.unique'      => 'The :attribute has already been taken.',
            'email.regex'       => 'The :attribute format is invalid.',
            'email.email'       => 'The :attribute format is invalid.',
            'email.max'         => 'The :attribute may not be greater than :max characters.',

            'address.required'  => 'The :attribute field is required.',
            'address.max'       => 'The :attribute may not be greater than :max characters.',
        ];
    }
}