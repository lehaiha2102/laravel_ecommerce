<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'parent_category' => 'nullable',
            'description' => 'required|string',
            'status' => 'boolean',
        ];
    }


    public function attributes()
    {
        return [
            'name' => 'Category name',
            'parent_category' => 'Parent category',
            'description' => 'Category description',
            'status' => 'Category status',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The :attribute field is required.',
            'description.required' => 'The :attribute field is required.',
        ];
    }
}
