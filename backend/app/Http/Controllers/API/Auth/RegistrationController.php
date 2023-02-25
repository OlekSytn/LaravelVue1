<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Auth\RegistrationRequest;

class RegistrationController extends BaseController
{
	
    /**
     * @group Authentication
     * 
     * Register
     *
     * @bodyParam  name string required. Md.Rabiul Hasan
     * @bodyParam  email string required. Email for login Example: mdrabiulhasan.me@gmail.com
     * @bodyParam  password string required. Example: 123456
     * @bodyParam  confirm_password string required. Example: 123456
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response 200{
     *           "success": true,
     *           "status_code": 200,
     *           "message": "User register successfully.",
     *           "data": {
     *               "name": "Ariful Islam",
     *               "token_type": "Bearer",
     *               "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNzQ4N2I2ZjI5YWM5YTIxNTI3ZjUwM2Y1ZjY3NGI2YTRkNzEwMTliZDlkNDIyMjM1ODQ1YjkzMzMzYzBjYTQ2NzIwZWEyZjQyOGFjZDk3ZjkiLCJpYXQiOjE2NjM5OTcyNDQuODM1NjA1LCJuYmYiOjE2NjM5OTcyNDQuODM1NjEsImV4cCI6MTY5NTUzMzI0NC43NzEyMDUsInN1YiI6IjYiLCJzY29wZXMiOltdfQ.WumQps2r4O8k8AF3jVaHSb09sivZJFHarVADfkFdR5V8EN9M2j_6_6mvqMiB_OAfwZ3hKF_X9H4q5WSjT3P4_-Z-NjmhFaVaAd9-P1boq9JNrCtO9pG8fybLSqeLRm2u15tLs0c-LuPHkpbhJgqN-JVMFVIIQXZe4TGBO57k5eiPvN0sB_Go5OOjxPaQbzE3hGeeeng4dshQ0ThMtaNgq4eLEM7hKXAtkToq7e1CJtQCE_fzM4A4uDLhqXYk_SrA2GpozNkvLDD8i8V91ynfFj3Jp94w6YrIB2jZ9PWDIG2-rpdLB2_Q-GFYrK09Da_aCXe1TJ3lRULJmF44FqvJWekz6xLrhL6NKHEaT0wkAe4Z7H5va8pj_yHcJWHoyr7Lt2q5Ta7cCHmm_fKtg-IHqBHuaBhHODwebxMggCfIpwv1NkK82CiKELNO70xGmExRM3VDGVSNO9Pm-kC5UWvuEU8lm5reIe-dsETTiz8gVvfjI-cO2f7G0KpW0Jiae6AdcPOiSIQpGEiqC7Q49M5cphzHB3knvsysRXbfiSS5j5hueyYOHhkTk0GQpuhAyCQUNbsIF1ek_B8MZBsME2y446ZS37pzKcYnVOTFfan2xvu6zKl32yAg3h46jk86qgd3gcGQOABGL7wtsQKWk7dw2DChd-nfLSh75gXD1e1JT7U"
     *           }
     *       }
     */
    public function registration(RegistrationRequest $request){
		
        $user = User::create([
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
		
		

        $token = $user->createToken($user->name)->accessToken;

        $success = [
            "name"       => $user->name,
            "token_type" => "Bearer",
            "token"      => $token
        ];
   
        return $this->sendResponse('User register successfully.', $success);
   
    }

}
