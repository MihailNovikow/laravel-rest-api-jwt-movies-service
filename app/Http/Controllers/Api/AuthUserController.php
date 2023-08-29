<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Contracts\Providers\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\UserRequest;

class AuthUserController extends ApiController
{
      public function __construct()
    {
        $this->middleware('Auth:api');//('Auth:api', ['except' => ['login','register']]);
    }

    public function showAuthUser($user_id)
    {
        $user = Auth::user();
        if($user->id = $user_id) {
        return response()->json([
            'status' => 'success',
            'user' => $user,
        ]);
    } else {
             return $this->respondNotFound();
        }
    }
 public function updateAuthUser(UserRequest $request, $user_id)
    {
        $user = Auth::user();
        if($user->id = $user_id) {
        $user->name = $request->name ? $request->name :  $user->name;
        $user->username = $request->username ? $request->username : $user->username;
        $user->password = $request->password ? $request->password : $user->password;
        $user->email = $request->email ?  $request->email : $user->password;
        $user->save();
        return response()->json([
            'status' => 'auth user updated',
            'user' => $user,
        ]); } else {
             return $this->respondNotFound();
        }
    }
     public function deleteAuthUser($user_id)
    {
        $user = Auth::user();
        if($user->id = $user_id) {
            $user->delete();
        return response()->json([
            'status' => 'auth user deleted',
            'user' => $user,
        ]);
        } else {
             return $this->respondNotFound();
        }

    }

}
