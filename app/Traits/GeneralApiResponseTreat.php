<?php

namespace App\Traits;

trait GeneralApiResponseTreat
{
    /**
     * @return string current language
     */
    public function getCurrentLang(){
        return app()->getLocale();
    }

    /**
     * @param $errorNum
     * @param $msg
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseError($msg, $statusCode = 400){
        return response()->json([
           'status'=> false,
            'message'=> $msg
        ], $statusCode);
    }

    /**
     * @param $successNum
     * @param $msg
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseSuccess($msg, $statusCode = 200){
        return response()->json([
           'status'=> true,
            'message'=> $msg
        ], $statusCode);
    }

    public function responseSuccessData($data, $msg = 'success send data'){
        $data = is_array($data) ? $data : ['data'=>$data];
        $data['status'] = true;
        $data['message'] = $msg;
        return response()->json($data, 200);
    }


    // not found
    public function responseNotFound($msg, $statusCode = 404){
        return response()->json([
            'status'=> false,
            'message'=> $msg
        ], $statusCode);
    }

    // not authenticated
    public function responseNotAuthenticated($msg, $statusCode = 401){
        return response()->json([
            'status'=> false,
            'message'=> $msg
        ], $statusCode);
    }




}
