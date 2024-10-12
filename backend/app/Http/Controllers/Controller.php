<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;

abstract class Controller
{
    protected function successResponse($message = null, $data = null ): Response
    {
        return response([
            'message' => $message,
            'data' => $data,
            'errors' => null
        ], 200);
    }

    protected function errorResponse($message = null, $errors = null ): Response
    {
        return response([
            'message' => $message,
            'data' => null,
            'errors' => $errors
        ], 400);
    }


}
