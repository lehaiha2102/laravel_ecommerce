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
            'name' => 'required|string|max:255',
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'import_price' => 'required|numeric',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'description' => 'nullable|string',
            'images.*' => 'required|image|max:1024',
            'category_id' =>'required|exists:categories,id',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Product name',
            'manufacturer_id' => 'Manufacturer',
            'category_id' => 'Category',
            'import_price' => 'Import price',
            'price' => 'Price',
            'quantity' => 'Quantity',
            'description' => 'Description',
            'images.*' => 'Image',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The :attribute field is required.',
            'name.string' => 'The :attribute field must be a string.',
            'name.max' => 'The :attribute field may not be greater than :max characters.',
            'manufacturer_id.required' => 'The :attribute field is required.',
            'manufacturer_id.exists' => 'The selected :attribute is invalid.',
            'category_id.required' => 'The :attribute field is required.',
            'category_id.exists' => 'The selected :attribute is invalid.',
            'import_price.required' => 'The :attribute field is required.',
            'import_price.numeric' => 'The :attribute field must be a number.',
            'price.required' => 'The :attribute field is required.',
            'price.numeric' => 'The :attribute field must be a number.',
            'quantity.required' => 'The :attribute field is required.',
            'quantity.integer' => 'The :attribute field must be an integer.',
            'description.string' => 'The :attribute field must be a string.',
            'images.*.required' => 'At least one :attribute is required.',
            'images.*.image' => 'The :attribute field must be an image file.',
            'images.*.max' => 'The :attribute may not be greater than :max kilobytes.',
        ];
    }
}
