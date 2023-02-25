<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Jobs\PasswordResetMailSendJob;
use App\Mail\PasswordResetMail;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgetPasswordController extends BaseController
{
      /**
     * @group Authentication
     * 
     * Forget-Password
     *
     * @bodyParam  email string required. Email for login Example: mdrabiulhasan.me@gmail.com
     * 
     * @response 200{
     *       "success": true,
     *       "status_code": 200,
     *       "message": "Password reset mail sent.",
     *       "data": {
     *           "reset_token": "VuEQfdGr4uTDOFNWGUEb"
     *       }
     *   }
     */
    public function forgetPassword(ForgetPasswordRequest $request){
    

        $email = $request->input('email');

        $user = User::where('email', $email)->first();
        if($user){
            $email = $user->email;
            $reset_token = $this->generateResetToken($email);

            $success = [
                "reset_token" => $reset_token 
            ];
       
            return $this->sendResponse('Password reset mail sent.', $success);

        }else{
            return $this->sendError('This email not registration yet', [], 404); 
        }
        
    }


    protected function generateResetToken($email){
        $token = Str::random(20);
        $password_reset = DB::table('password_resets')->where('email', $email)->first();
        if($password_reset){
            DB::table('password_resets')->where('email', $email)->update([
                "token" => $token
            ]);
        }else{
            DB::table('password_resets')->insert([
                "email" => $email,
                "token" => $token
            ]);
        }
        $this->sendPasswordResetMail($email, $token);
        return $token;
    }

    protected function sendPasswordResetMail($email, $token){
        $details = [
            'email' => $email,
            'subject' => 'Password Reset',
            'url' => "https://sprightly-cucurucho-a3d1f7.netlify.app/reset-password/$token"
        ];
        Mail::to($details['email'])->send(new PasswordResetMail($details));
        // dispatch(new PasswordResetMailSendJob($details));
    }

}
