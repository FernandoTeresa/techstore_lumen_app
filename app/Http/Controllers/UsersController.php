<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        return response()->json($user,200);
    }

    public function newUser(Request $request)
    {
    
        $this->validate($request, [
            'username'=> 'required|unique:users,username',
            'password'=> ['required', Password::min(8)],
            'first_name'=> 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
        ]);
        $user = new User($request->all());
        $user->save($request->all());
        return response()->json($user,200);
    }




}