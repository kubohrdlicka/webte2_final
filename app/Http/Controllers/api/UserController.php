<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


use App\Models\User;

class UserController extends Controller
{

    public function getAllUsers()
    {
        $users = User::all()->toArray();
        return response()->json($users, 200);
    }
    public function register(Request $request)
    {
        $validador = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email|unique:user",
            "password" => "required|min:6",
        ]);

        if ($validador->fails()) {
            return response()->json(["error" => $validador->errors()], 401);
        }

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "role" => 'student'
        ]);


        if ($user) {
            return response()->json(["data" => "User created successfully"], 200);

        } else {
            return response()->json(["error" => "User not created"], 500);
        }
    }

    public function logIn(Request $request)
    {
        $input = $request->only('email', 'password');
        $jwt_token = null;

        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'role' => auth()->user()->role,
            'token' => $jwt_token,
        ]);
    }


    public function createSuperUser(Request $request)
    {
        $validador = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email|unique:user",
            "password" => "required|min:6",
        ]);

        if ($validador->fails()) {
            return response()->json(["error" => $validador->errors()], 401);
        }

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "role" => 'admin'
        ]);

        if ($user) {
            return response()->json(["data" => "SuperUser created successfully"], 200);
        } else {
            return response()->json(["error" => "User not created"], 500);
        }
    }

    public function changeRole(Request $request, $id)
    {   
        Validator::make($request->all(), [
            "role" => "required",
        ]);

        $user = User::where('id', $id)->first();

        if ($user) {
            $user->role = $request->role;
            $user->save();
            return response()->json(["data" => "Role changed successfully"], 200);
        } else {
            return response()->json(["error" => "User not found"], 500);
        }
    }

    public function deleteUser($id)
    {

        $user = User::where('id', $id)->first();

        if ($user) {
            $user->delete();
            return response()->json(["data" => "User deleted successfully"], 200);
        } else {
            return response()->json(["error" => "User not found"], 500);
        }
    }

    public function refresh(Request $request)
    {
        // $headerValue = $request->header('Authorization');

        $token = JWTAuth::parsetoken()->refresh();
        
        // $newToken = auth()->refresh();
        return response()->json([
            'success' => true,
            'token' => $token,
        ],200);
    }

    public function logOut()
    {
        // $token = auth()->getToken();
        // $newToken = JWTAuth::invalidate($token);
        return response()->json([
            'success' => true,
        ],200);
    }



}