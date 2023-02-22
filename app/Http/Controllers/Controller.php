<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function success($data = null, $statusCode = 200)
    {
        return response()->json([
            'status' => true,
            'result' => $data
        ], $statusCode ?? HttpResponse::HTTP_OK);
    }

    protected function error($message, $statusCode = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], $statusCode ?? HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}
