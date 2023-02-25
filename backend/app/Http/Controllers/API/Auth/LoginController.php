<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class LoginController extends BaseController
{
    /**
     * @group Authentication
     * 
     * Login
     *
     * @bodyParam  email string required. Email for login Example: mdrabiulhasan.me@gmail.com
     * @bodyParam  password string required. Passwrod for login Example: 123456
     * @responseField success The success of this API response is (`true` or `false`).
     * 
     * @response 200{
     *       "success": true,
     *       "status_code": 200,
     *       "message": "User login successfully.",
     *       "data": {
     *           "name": "Rabiul Hasan",
     *           "token_type": "Bearer",
     *           "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZDkxMWQ2ZWU3ODliZGE5NzZlNmYyYjdhOGVjNGJkYzBhMjUxMzRjNTExMTQ3OGM0NzQwZWVlY2ZiMDNjMDExNThhMDQ0MjYzZWYwNDcxNmMiLCJpYXQiOjE2NjM5OTcwMjYuMDY1MzczLCJuYmYiOjE2NjM5OTcwMjYuMDY1Mzc5LCJleHAiOjE2OTU1MzMwMjUuODk3MzQ5LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.mdGij29naRU4_0munG-pkV2qqGdilPcqjz9lnTdl_L5FW5b-eaX8gwm9EDWxUlAM8wLq1BnvYM3ahOyO61he_ZA_S8aeeGeRMg4ymc8ZYGxjj1XT_d7YhEIx1sOBj9g7dVlXrk76b5DCejATxk8MPahQduxg51oRwTDum-9MMuAoazf6g6kEAc7IemELQPPI7MsoySCYYjQef2ZDV3UKsmTKXYsw81YPse6TWEvrEaRUOE5DzjwLEPj806vYcgIbq5ExMGRYH49uV09N6kTlxMW8zuAqL23VJTyl1SI_9JhlFQdy__ufC7zAZh5S-PKvByrlIltfCgdsE17a90YZBzmp0uj9GgQTH5inNx9ekpRpMcVb6ZvXjlPccj8TGCTsNy7MajPP9DedFG-hECFE0SLudqvdd-icTY48MOwCG-RAQsHiqGZkSgyhxiyCZIshVCtxJuFg6zJyi9-_19Xm5gbyj5DFaI3z3Z2ZvGItFCeklsE99oLTlu6cuK5EZDM5-WloflVSnK0D6GoikzVlFkDDeDX4UAdzpD2LkX52rQZwpbEPc8LPde6w418TkGiGTH8fhS_tdH8e2iR2wpXppZiPH_aZSYEnWVBbLTUHq8AlibnmzzYxeOdrNvgTCFk-SIIbfQcTt40WQG1AE-X6Gr2fW-vfqD3Gw6Z_XYJfhek"
     *       }
     *   } 
     */
    public function login(LoginRequest $request)
    {
       
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user  = Auth::user();
            $token = $user->createToken($user->name)->accessToken;
            
            $success = [
                "name"       => $user->name,
                "token_type" => "Bearer",
                "token"      => $token
            ];   
            return $this->sendResponse( 'User login successfully.', $success);
        } 
        else{ 
            return $this->sendError('email or password was incorrect.', ['error'=>'email or password was incorrect'], 200);
        } 
    }
}
