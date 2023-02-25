<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController;

class UserInformationController extends BaseController
{

    /**
     * @group Authentication
     * 
     * User Information
     * @authenticated
     * @header Authorization Bearer token
     * 
     * @response 200{
     *       "success": true,
     *       "status_code": 200,
     *       "message": "User Fetch successfully.",
     *       "data": {
     *           "name": "Rabiul Hasan",
     *           "email": "rabiul.fci@gmail.com"
     *       }
     *   }
     */
    public function userInfo(){      		
        $success = [
            "name"  => Auth::user()->name,
            "email" => Auth::user()->email,
        ];   
        return $this->sendResponse('User Fetch successfully.', $success);
    }
}
