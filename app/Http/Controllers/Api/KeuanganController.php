<?php

namespace App\Http\Controllers\Api;

use App\Models\Keuangan;
use Illuminate\Http\Request;
use App\Http\Resources\KeuanganResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KeuanganController
{
    public function index() 
    {
        $uang = Keuangan::get();
        if($uang->count() > 0) 
        {
            return KeuanganResource::collection($uang);
        } 
        else 
        {
            return response()->json(['message' => 'Data not found'], 200);
        }
    }

    public function show(Keuangan $uang) 
    {
        return new KeuanganResource($uang);
    }

    public function store(Request $request) 
    {
        $validator = Validator::make($request->all(),[
                    'no_spm' => 'required|integer',
                    'sp2d' => 'required|string|max:255',
                    'tahun_anggaran' => 'required|integer|digits:4',
                    'jenis' => 'required|string|max:255',
                    'bidang' => 'required|string|max:255',
                    'tgl_input' => 'required|date',
                    'jumlah_anggaran' => 'required|integer',
                    'id_pengajuan' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be filled',
                'error' => $validator->messages(),
            ], 422);
        }

        $uang = Keuangan::create([
            'no_spm' => $request->no_spm,
            'sp2d' => $request->sp2d,
            'tahun_anggaran' => $request->tahun_anggaran,
            'jenis' => $request->jenis,
            'bidang' => $request->bidang,
            'tgl_input' => $request->tgl_input,
            'jumlah_anggaran' => $request->jumlah_anggaran,
            'id_pengajuan' => $request->id_pengajuan,
        ]);

        return response()->json([
            'message' => 'Data added successfully',
            'data' => new KeuanganResource($uang)
        ], 200);
    }

    public function update(Request $request, Keuangan $uang) 
    {
        $validator = Validator::make($request->all(),[
                    'no_spm' => 'sometimes|required|integer',
                    'sp2d' => 'sometimes|required|string|max:255',
                    'tahun_anggaran' => 'sometimes|required|integer|digits:4',
                    'jenis' => 'sometimes|required|string|max:255',
                    'bidang' => 'sometimes|required|string|max:255',
                    'tgl_input' => 'sometimes|required|date',
                    'jumlah_anggaran' => 'sometimes|required|integer',
                    'id_pengajuan' => 'sometimes|required|integer',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be filled',
                'error' => $validator->messages(),
            ], 422);
        }

        $uang->update([
            'no_spm' => $request->no_spm,
            'sp2d' => $request->sp2d,
            'tahun_anggaran' => $request->tahun_anggaran,
            'jenis' => $request->jenis,
            'bidang' => $request->bidang,
            'tgl_input' => $request->tgl_input,
            'jumlah_anggaran' => $request->jumlah_anggaran,
            'id_pengajuan' => $request->id_pengajuan,
        ]);

        return response()->json([
            'message' => 'Data updated successfully',
            'data' => new KeuanganResource($uang)
        ], 200);
    }

    public function destroy(Keuangan $uang) 
    {
        $uang->delete();

        return response()->json([
            'message' => 'Data deleted successfully',
        ], 200);
    }
}
