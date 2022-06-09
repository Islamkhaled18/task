<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Traits\UserTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    use UserTrait;

    public function index(){
        $users = User::with('products')->get();
        return $this->userApiResponse($users,'ok',200);

    }
    public function show($id){

        $user = User::find($id);

        if ($user) {
                $user = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'phone' => $user['phone'],
                    'image' => $user['image'],
                    'product' => $user['products'],
                ];
            
            return $this->userApiResponse($user, 'ok', 200);
        }
        return $this->userApiResponse(null, 'The user Not Found', 404);

    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|unique:users',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->userApiResponse(null,$validator->errors(),400);
        }

        $file_name = $this->saveImage($request->image, 'images/users');    

         //insert table users in database
        
        $user = User::create([
            'image' => $file_name,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password) ,

        ]);

        if($user){
            return $this->userApiResponse(new UserResource($user),'The User Saved',201);
        }

        return $this->userApiResponse(null,'The User Not Save',400);

    }//store new user


    public function update(Request $request ,$id){

        $user = User::find($id);

        if(!$user){
            return $this->userApiResponse(null,'The user Not Found',404);
        }

        $file_name = $this->saveImage($request->image, 'images/users');     

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'image' => $file_name,
        ]);

        if($user){
            return $this->userApiResponse(new UserResource($user),'The user update',201);
        }

    }

    
}
