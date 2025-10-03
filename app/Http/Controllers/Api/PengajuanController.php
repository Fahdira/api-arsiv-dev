<?php

namespace App\Http\Controllers\Api;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Http\Resources\PengajuanResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PengajuanController
{
    public function index()
    {
        $pengajuan = Pengajuan::get();
        if($pengajuan->count() > 0) 
        {
            return PengajuanResource::collection($pengajuan);
        } 
        else 
        {
            return response()->json(['message' => 'Data not found'], 200);
        }
    }

    public function show(Pengajuan $pengajuan)
    {
        return new PengajuanResource($pengajuan);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                    'id_user' => 'required|integer',
                    'id_jenis_pengajuan' => 'required|integer',
        ]);
        
        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be filled',
                'error' => $validator->messages(),
            ], 422);
        }

        $pengajuan = Pengajuan::create([
            'id_user' => $request->id_user,
            'id_jenis_pengajuan' => $request->id_jenis_pengajuan,
        ]);

        return response()->json([
            'message' => 'Data added successfully',
            'data' => new PengajuanResource($pengajuan)
        ], 200);
    }

    public function update(Request $request, Pengajuan $pengajuan)
    {
        $validator = Validator::make($request->all(),[
                    'id_user' => 'sometimes|required|integer',
                    'id_jenis_pengajuan' => 'sometimes|required|integer',
        ]);
        
        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be filled',
                'error' => $validator->messages(),
            ], 422);
        }

        $pengajuan->update([
            'id_user' => $request->id_user,
            'id_jenis_pengajuan' => $request->id_jenis_pengajuan,
        ]);

        return response()->json([
            'message' => 'Data updated successfully',
            'data' => new PengajuanResource($pengajuan)
        ], 200);
    }

    public function destroy(Pengajuan $pengajuan)
    {
        $pengajuan->delete();
        return response()->json([
            'message' => 'Data deleted successfully',
        ], 200);
    }
}
