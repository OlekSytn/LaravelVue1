<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($message, $data, $code = 200)
    {
    	$response = [
            'success'     => true,
            'status_code' => $code,
            'message'     => $message
        ];

        if(!empty($data)){
            $response['data'] = $data;
        }

        return response()->json($response);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success'     => false,
            'message'     => $error,
            'status_code' => $code
        ];

        if(!empty($errorMessages)){
            $response['errors'] = $errorMessages;
        }

        return response()->json($response);
    }

}
