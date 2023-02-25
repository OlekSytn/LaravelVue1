<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ForgetPasswordRequest extends FormRequest
{
    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
   public function rules()
   {
       return [
        'email'            => 'required|email',
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
           'email.required'            => 'Please enter your email address name',
           'email.email'               => 'Invalid email address',
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
