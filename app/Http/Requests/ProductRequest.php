<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [ 'name' => ['required', 'max:255', 'unique:products,name'],
            'price' => ['required', 'numeric'],
            'category_id' => ['required', 'exists:categories,id'],
            'tax' => ['required', 'numeric'],
            'stock' => ['required', 'integer'],
            'image' => ['image','required'],
        ];

        if (request()->route()->named('products.update')) {
            $rules['name'] = ['required', 'max:255', Rule::unique('products', 'name')->ignore(request()->route('product')->id)];
            $rules['image'] = ['image'];
        }

        return $rules;
    }
}
