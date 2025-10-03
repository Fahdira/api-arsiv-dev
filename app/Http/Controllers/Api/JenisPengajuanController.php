<?php

namespace App\Http\Controllers\Api;

use App\Models\JenisPengajuan;
use Illuminate\Http\Request;
use App\Http\Resources\JenisPengajuanResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class JenisPengajuanController
{
    public function index()
    {
        $jenis_pengajuan = JenisPengajuan::get();
        if($jenis_pengajuan->count() > 0) 
        {
            return JenisPengajuanResource::collection($jenis_pengajuan);
        } 
        else 
        {
            return response()->json(['message' => 'Data not found'], 200);
        }
    }

    public function show(JenisPengajuan $jenis_pengajuan)
    {
        return new JenisPengajuanResource($jenis_pengajuan);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                    'nama_pengajuan' => 'required|string|max:255',
        ]);
        
        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be filled',
                'error' => $validator->messages(),
            ], 422);
        }

        $jenis_pengajuan = JenisPengajuan::create([
            'nama_pengajuan' => $request->nama_pengajuan,
        ]);

        return response()->json([
            'message' => 'Data added successfully',
            'data' => new JenisPengajuanResource($jenis_pengajuan)
        ], 200);
    }

    public function update(Request $request, JenisPengajuan $jenis_pengajuan)
    {
        $validator = Validator::make($request->all(),[
                    'nama_pengajuan' => 'sometimes|required|string|max:255'
        ]);
        
        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be filled',
                'error' => $validator->messages(),
            ], 422);
        }

        $jenis_pengajuan->update([
            'nama_pengajuan' => $request->nama_pengajuan
        ]);

        return response()->json([
            'message' => 'Data updated successfully',
            'data' => new JenisPengajuanResource($jenis_pengajuan)
        ], 200);
    }

    public function destroy(JenisPengajuan $jenis_pengajuan)
    {
        $jenis_pengajuan->delete();
        return response()->json([
            'message' => 'Data deleted successfully',
        ], 200);
    }
}
