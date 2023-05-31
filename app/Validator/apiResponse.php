<?php
namespace App\Validator;
trait apiResponse
{
    protected function responseApiWithSuccess($message='',$data=[],$code=200)
    {
        return response()->json([
            'success'=> true,
            'message'=> $message,
            'data'   => $data
        ],$code);
    }
    protected function responseApiWithError($message='',$data=[],$code=400)
    {
        return response()->json([
            'error'   => true,
            'message' => $message,
            'data'    => $data
        ],$code);
    }
}
