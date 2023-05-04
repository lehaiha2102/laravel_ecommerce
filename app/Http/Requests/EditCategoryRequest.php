<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditCategoryRequest extends FormRequest
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
            // 'parent_category.exists' => 'The selected :attribute is invalid.',
            'description.required' => 'The :attribute field is required.',
        ];
    }
}
