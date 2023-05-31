<?php
namespace App\Validator;
use Illuminate\Support\Facades\Validator;
trait validatorForm
{
    /* validation function */
    protected function validationWithJson( $data=[],$rules=[],$message=[] )
    {
        
        $validator = Validator::make( $data, $rules,$message);

        if ($validator->fails()){
            //return $validator->errors();
            return $validator->messages()->all();

        }else{
            return true;
        }
    }
    /* validation get Form data  */
    protected function getFormData( $data=[], $rules=[] )
    {
        $fromData = array();
        foreach($rules as $key=>$value)
        {
            if (array_key_exists($key,$data)){
                $fromData[$key] = $data[$key];
            }else{
                $fromData[$key] = null;
            }
        }
        //dd($fromData);
        return $fromData;
    }
    protected function responseWithSuccess($message='',$data=[],$code=200)
    {
        return response()->json([
            'success'=> true,
            'message'=> $message,
            'data'   => $data
        ],$code);
    }
    protected function responseWithError($message='',$data=[],$code=400)
    {
        return response()->json([
            'error'   => true,
            'message' => $message,
            'data'    => $data
        ],$code);
    }
}
