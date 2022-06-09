<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Traits\UserTrait;

class UserController extends Controller
{
    use UserTrait;

    public function index(){
        return view('users.users');
    }//end of users view

    public function fetchUsers(){
        $users = User::all();
        return response()->json([
            'users'=>$users,
        ]);

    }//create a new user

    public function store(Request $request){

        $file_name = $this->saveImage($request->image, 'images/users');
        //insert  table users in database
        
         User::create([
            'image' => $file_name,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password) ,

        ]);


    }//store new user
}
