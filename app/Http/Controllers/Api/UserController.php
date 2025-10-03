<?php

namespace App\Http\Controllers\Api;

use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController
{
    public function index()
    {
        $user = Users::get();
        if($user->count() > 0) 
        {
            return UserResource::collection($user);
        } 
        else 
        {
            return response()->json(['message' => 'Data not found'], 200);
        }
    }

    public function show(Users $user)
    {
        return new UserResource($user);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                    'email' => 'required|email|max:255',
                    'nama' => 'required|string|max:255',
                    'username' => 'required|string|max:255',
                    'id_jabatan' => 'required|integer',
                    'password' => 'required|string|max:255'
        ]);
        
        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be filled',
                'error' => $validator->messages(),
            ], 422);
        }

        $user = Users::create([
            'email' => $request->email,
            'nama' => $request->nama,
            'username' => $request->username,
            'id_jabatan' => $request->id_jabatan,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'Data added successfully',
            'data' => new UserResource($user)
        ], 200);
    }

    public function update(Request $request, Users $user)
    {
        $validator = Validator::make($request->all(),[
                    'email' => 'sometimes|required|email|max:255',
                    'nama' => 'sometimes|required|string|max:255',
                    'username' => 'sometimes|required|string|max:255',
                    'id_jabatan' => 'sometimes|required|integer',
                    'password' => 'sometimes|required|string|max:255'
        ]);
        
        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be filled',
                'error' => $validator->messages(),
            ], 422);
        }

        $user->update([
            'email' => $request->email,
            'nama' => $request->nama,
            'username' => $request->username,
            'id_jabatan' => $request->id_jabatan,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'Data updated successfully',
            'data' => new UserResource($user)
        ], 200);
    }

    public function destroy(Users $user)
    {
        $user->delete();
        return response()->json([
            'message' => 'Data deleted successfully',
        ], 200);
    }
}
