<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegistrationRequest extends FormRequest
{
    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
   public function rules()
   {
       return [
        'name'             => 'required',
        'email'            => 'required|email|unique:users,email',
        'password'         => 'required',
        'confirm_password' => 'required|same:password',
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
           'name.required'             => 'Please enter your name',
           'email.required'            => 'Please enter your email address name',
           'email.email'               => 'Invalid email address',
           'email.unique'              => 'This email already exists',
           'password.required'         => 'Please enter your password',
           'confirm_password.required' => 'Please enter your confirm-password',
           'confirm_password.same'     => 'Your password and confirm password did not match',
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
