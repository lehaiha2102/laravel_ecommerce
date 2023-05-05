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
            'name' => 'required|string|max:255|unique:categories,name',
            'parent_category' => 'nullable',
            'description' => 'required|string',
            'status' => 'boolean',
            'image' => 'required|file|mimes:jpg,jpeg,png,gif|max:2048',
        ];
    }


    public function attributes()
    {
        return [
            'name' => 'category name',
            'parent_category' => 'parent category',
            'description' => 'category description',
            'status' => 'category status',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The :attribute field is required.',
            'name.max' => 'The :attribute may not be greater than :max characters.',
            'name.string' =>'The :attribute must be a string.',
            'name.unique' => 'The :attribute has already been taken.',
            'description.required' => 'The :attribute field is required.',
            'status.boolean' => 'The :attribute field must be true or false.',
            'image.required' => 'The :attribute field is required.',
            'image.file' => 'The :attribute must be a file.',
            'image.mimes'=> 'The :attribute must be a file of type: :values.',
            'image.max' => 'The :attribute may not be greater than :max kilobytes.',
        ];
    }
}
