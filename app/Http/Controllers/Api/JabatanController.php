<?php

namespace App\Http\Controllers\Api;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use App\Http\Resources\JabatanResource;
use Illuminate\Support\Facades\Validator;

class JabatanController
{
    public function index()
    {
        $jabatan = Jabatan::get();
        if($jabatan->count() > 0) 
        {
            return JabatanResource::collection($jabatan);
        } 
        else 
        {
            return response()->json(['message' => 'Data not found'], 200);
        }
    }

    public function show(Jabatan $jabatan)
    {
        return new JabatanResource($jabatan);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                    'nama_jabatan' => 'required|string|max:255'
        ]);
        
        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be filled',
                'error' => $validator->messages(),
            ], 422);
        }

        $jabatan = Jabatan::create([
            'nama_jabatan' => $request->nama_jabatan
        ]);

        return response()->json([
            'message' => 'Data added successfully',
            'data' => new JabatanResource($jabatan)
        ], 200);
    }

    public function update(Request $request, Jabatan $jabatan)
    {
        $validator = Validator::make($request->all(),[
                    'nama_jabatan' => 'sometimes|required|string|max:255'
        ]);
        
        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be filled',
                'error' => $validator->messages(),
            ], 422);
        }

        $jabatan->update([
            'nama_jabatan' => $request->nama_jabatan
        ]);

        return response()->json([
            'message' => 'Data updated successfully',
            'data' => new JabatanResource($jabatan)
        ], 200);
    }

    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();
        return response()->json([
            'message' => 'Data deleted successfully',
        ], 200);
    }
}
