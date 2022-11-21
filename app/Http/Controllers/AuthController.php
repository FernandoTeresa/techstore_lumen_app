<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\User;
use App\Models\UserInfo;
use Carbon\Carbon;

class AuthController extends Controller
{


    public function login(Request $request)
    {

        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['username', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }


        return $this->respondWithToken($token);

    }


    public function checkPass(Request $request){

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only(['username', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(401);
        }
            return response()->json(200);

    }

    public function me(Request $request)
    {
        return response()->json(auth()->user());
    }


    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        
        return $this->respondWithToken(auth()->refresh());
    }

  
    protected function respondWithToken($token)
    {
        $user=User::where(['id'=>auth()->user()->id])->first();
        return response()->json([
            'access_token' => $token,
            'expires_in' => (auth()->factory()->getTTL() * 60 * 24) + Carbon::now()->timestamp,
        ]);
    }
}