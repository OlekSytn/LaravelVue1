<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Auth\ResetPasswordPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends BaseController
{
    /**
     * @group Authentication
     * 
     * Password-Reset
     *
     * @urlParam token required The token for the password-reset. Example: VuEQfdGr4uTDOFNWGUEb
     * @bodyParam  password string required. Example: 123456
     * @bodyParam  confirm_password string required. Example: 123456
     * 
     * @response 200{
     *       "success": true,
     *       "status_code": 200,
     *       "message": "User Password Reset successfully. Please login",
     *       "data": {
     *           "name": "Rabiul Hasan",
     *           "token_type": "Bearer",
     *           "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYjY1NjU1NjFkZmY3ZWM4MzMyMWE5YTQzMjgyNDExMzYxMWMyYjRjZDk4YWExODMzMmQ5NDQ0MzliZWMzMGMzOGE2ODJhZjg1NjQ0Y2ZhOGEiLCJpYXQiOjE2NjM5OTc1MjkuMjk0NTQyLCJuYmYiOjE2NjM5OTc1MjkuMjk0NTQ3LCJleHAiOjE2OTU1MzM1MjkuMjU2NjIsInN1YiI6IjEiLCJzY29wZXMiOltdfQ.E96NWszsK4GEVgUuDKM7hpNgr8Z6aY7mZur68PJuPPAh5qsFYBVoIx0RO0K-tcfs6fegm3cwTM9HZK9ezhHFbuexcdQt_OlMDDqtNVPYQERhuqzTsdUUUeQFnRdeLRo-0vw76LaJJT6JYdaZIJqEE0mXCmiwZyd3J3ocjm9yVAFAQHlvpljBWmdPr23ktNS3K_Srwpvhc9Cb158ZLZlMjoHO2ObAE3QBwOvG8Iybj_SZSFxuwcwtGQfJKSmwsBzWmgAYcK3IwBBGJ_lOuDsl-nZnha7oQyyKRVGAqJ7RfSalKfdE8P64Q7-Z8QVLxBOhBGpWjj-48Qx7bLkdmuZUqRW5H2w6sUs4Lj2A_Md3iJqh3Q3F7RpNEH3DuCGK9cBlopovr8Mwq-FDohR9ehEKTORz9ImssJvCe1J4SgEetE11LXloi3_x1sy_BwfLQsJLw7_ofV0eSCPt0oEfe-ORNrqs_aoKY_TfinkcEKTG5IDg6eHvWkeigZvFlv-ex_pAmn0UbG2INuwA-0ZCLSlIydosOu6AkUlqSgUnt0kgN9wNY8pWOGbLchvPBUMVREFYb_BGtPTkmk7y8cnFGEnt45kMFP3EjMEk2j0CrqVZj9xqnaJO401UEHN2cjVQVrZEIB2iBWt-DKAoonl4qFsC-2vs0Nc173bpH9TPxOAA_Fc"
     *       }
     *   } 
     */
    public function passwordReset($token, ResetPasswordPasswordRequest $request){       

        $reset_token = DB::table('password_resets')->where('token', $token)->first();
        if($reset_token){

            $user = User::where('email', $reset_token->email)->first();
            DB::table('users')->where('email', $reset_token->email)->update([
                "password" => Hash::make($request->input('password'))
            ]);

            $token = $user->createToken($user->name)->accessToken;
            
            $success = [
                "name"       => $user->name,
                "token_type" => "Bearer",
                "token"      => $token
            ];
   
            return $this->sendResponse('User Password Reset successfully. Please login', $success);


        }else{
            return $this->sendError('Invalid token', [], 404);
        }

    }
}
