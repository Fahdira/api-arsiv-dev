<?php

namespace App\Http\Controllers\Api;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController
{
    public function login(Request $request) : JsonResponse
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        $user = Users::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'The provided credentials are incorrect'
            ], 401);
        }

        $token = $user->createToken($user->username.'Auth-Token')->plainTextToken;
        return response()->json([
                'message' => 'Login is Successful',
                'token' => $token
            ], 201);
    }   

    public function register(Request $request) : JsonResponse
    {
        $request->validate([
            'email' => 'required|email|unique:users,email|max:255',
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'id_jabatan' => 'required|integer',
            'password' => 'required|string|max:255',
        ]);

        $user = Users::create([
            'email' => $request->email,
            'nama' => $request->nama,
            'username' => $request->username,
            'id_jabatan' => $request->id_jabatan,
            'password' => Hash::make($request->password),
        ]);

        if($user) {
            $token = $user->createToken($user->username.'Auth-Token')->plainTextToken;
            return response()->json([
                    'message' => 'Register is Successful',
                    'token' => $token
                ], 201);
        } else {
            return response()->json([
                    'message' => 'Something went wrong'
                ], 500);
        }
    }

    public function logout(Request $request) {
        $user = Users::where('id',$request->user()->id)->first();
        if($user){
            $user->tokens()->delete();
            return response()->json([
                    'message' => 'Logged Out Successfully'
                ], 200);
        } else {
            return response()->json([
                    'message' => 'Something went wrong'
                ], 500);
        }
    }

    public function profile(Request $request) {
        if($request->user())
        {
            return response()->json([
                    'message' => 'Profile Fetched.',
                    'data' =>  $request->user(),
                ], 200);
        } else {
            return response()->json([
                    'message' => 'Not Authenticated'
                ], 401);
        }
    }
}
