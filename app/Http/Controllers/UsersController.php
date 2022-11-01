<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\File;


class UsersController extends Controller
{

    public function getUser($id)
    {
        $user = User::find($id);
        $userInfo = UserInfo::where(['user_id'=> $id]);

        return response()->json($userInfo, 200);
    }

    public function register(Request $request)
    {
    
        $this->validate($request, [
            'username'=> 'required|unique:users,username',
            'password'=> ['required', Password::min(8)],
            'first_name'=> 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email'

        ]);

        $user = new User($request->all());
        $user->save($request->all());
        return response()->json($user,200);
    }

    public function updateUser(Request $request, $user_id)
    {

        $log = auth()->user();
        $payload = $request->all();
        $this->validate($request, [
            'password'=> [Password::min(8)],
            'raw_password' =>
            [
            
                function ($attribute, $value, $fail) use ($payload) {

                    if($payload['password'] != $value){
                        $fail('Passwords dont match');
                    }
                },Password::min(8)
            ],

            'first_name'=> 'string',
            'last_name' => 'string',
            'email' => 'email',

            'address_1'=> 'string',
            'address_2'=> 'string',
            'city' => 'string',
            'postal_code' => 'string',
            'country' => 'string',
            'mobile' => 'integer',
            'telephone' => 'integer'
        ]);

        if ($log->id == $user_id){

            $user = User::where(['id' =>$user_id])->first();
            $user_info = UserInfo::where(['user_id'=>$user_id])->first();
        
            if ($request->password != $user->password){
                $user->password = Hash::make($request->password);
            }

            if ($request->first_name != $user->first_name){
                $user->first_name = $request->first_name;
            }

            if ($request->last_name != $user->last_name){
                $user->last_name = $request->last_name;
            }

            if ($request->email != $user->email){
                $user->email = $request->email;
            }


            if ($request->address_1 != $user_info->address_1){
                $user_info->address_1 = $request->address_1;
            }
            
            if ($request->address_2 != $user_info->address_2){
                $user_info->address_2 = $request->address_2;
            }

            if($request->city != $user_info->city){
                $user_info->city = $request->city;
            }

            if($request->postal_code != $user_info->postal_code){
                $user_info->postal_code = $request->postal_code;
            }

            if($request->country != $user_info->country){
                $user_info->country = $request->country;
            }


            if($request->mobile != $user_info->mobile){
                $user_info->mobile = $request->mobile;
            }

            if($request->telephone != $user_info->telephone){
                $user_info->telephone = $request->telephone;
            }


            $user->save();
            $user_info->save();

            return response()->json('Profile Updated successfully!');
        }else{
            return response()->json([
                'status' => '401',
                'message' => 'Unauthorized Request'
            ]);
        };
    }

    public function newUser(Request $request)
    {
        $this->validate($request, [
            'username'=> 'required|unique:users,username',
            'password'=> ['required', Password::min(8)],
            'first_name'=> 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'admin'=> 'required'
        ]);

        $user = new User($request->all());
        if ($user->admin != null){
            $user->admin = $request->admin;
        }
        $user->save($request->all());

        return response()->json($user,200);
    }


}