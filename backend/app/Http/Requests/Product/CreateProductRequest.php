<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CreateProductRequest extends FormRequest
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
            'name'        => 'required',
            'details'        => 'required',
            'price'       => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image'      => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    } 

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'        => 'Please enter product name',
            'details.required'     => 'Please enter product details',
            'price.required'       => 'Please enter product price',
            'price.numeric'        => 'Price must be numeric format',
            'category_id.required' => 'Please select product category',
            'category_id.exists'   => 'Category not exists',
            'image.required'       => 'Please enter product image',
            'image.mimes'          => 'Invalid image format'
        ];
    }

    /**
     * Get the error json response for the defined http response exception
     *
     * @return json
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'status'  => 400,
            'message' => $validator->errors()->first()
        ]));
    }
}
