<?php

namespace App\Traits;

Trait  UserTrait
{
     function saveImage($image,$folder){
        //save image in folder
        $file_extension = $image -> getClientOriginalExtension();
        $file_name = time().'.'.$file_extension;
        $path = $folder;
        $image -> move($path,$file_name);

        return $file_name;
    }

    public function userApiResponse($data= null,$message = null,$status = null){

        $array = [
            'data'=>$data,
            'message'=>$message,
            'status'=>$status,
        ];
 
        return response($array,$status);
 
    }



}
