<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //public function penerapan inheritance //kontroller mewarisi pada turunanya
    public function successResponse($result, $message){
       
        $response=[
            'success' => true,
            'message' => $message,
            'data' => $result,
        ];

       return response()->json($response,200);
    }
    //gunakan  return $this->errorResponse('Validation Error',$validator->errors());
}
