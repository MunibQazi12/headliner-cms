<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message, $code = 200)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
            'code' => $code,
        ];

        return response()->json($response);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 550)
    {
        $response = [
            'success' => false,
            'error' => $errorMessages,
            'message' => $error,
            'code' => $code,
        ];

        return response()->json($response);
    }
}
