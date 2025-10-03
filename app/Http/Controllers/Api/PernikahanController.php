<?php

namespace App\Http\Controllers\Api;

use App\Models\Pernikahan;
use Illuminate\Http\Request;
use App\Http\Resources\PernikahanResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PernikahanController
{
    public function index() 
    {
        $nikah = Pernikahan::get();
        if($nikah->count() > 0) 
        {
            return PernikahanResource::collection($nikah);
        } 
        else 
        {
            return response()->json(['message' => 'Data not found'], 200);
        }
    }

    public function show(Pernikahan $nikah) 
    {
        return new PernikahanResource($nikah);
    }

    public function store(Request $request) 
    {
        $validator = Validator::make($request->all(),[
                    'id_suami' => 'required|integer',
                    'id_istri' => 'required|integer',
                    'tempat_nikah' => 'required|string|max:255',
                    'id_wali' => 'required|integer',
                    'id_saksi' => 'required|integer',
                    'no_kk' => 'required|integer',
                    'id_pengajuan' => 'required|integer',
                    'tgl_terbit' => 'required|date',
                    'file_nikah' => 'required|mimes:jpg,jpeg,png,pdf',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be filled',
                'error' => $validator->messages(),
            ], 422);
        }

        $file = $request->file('file_nikah');
        $fileName = time() . '_' . $file->getClientOriginalName();
        Storage::putFileAs('public/nikah', $file, $fileName);

        $nikah = Pernikahan::create([
            'id_suami' => $request->id_suami,
            'id_istri' => $request->id_istri,
            'tempat_nikah' => $request->tempat_nikah,
            'id_wali' => $request->id_wali,
            'id_saksi' => $request->id_saksi,
            'no_kk' => $request->no_kk,
            'tgl_terbit' => $request->tgl_terbit,
            'id_pengajuan' => $request->id_pengajuan,
            'file_nikah' => $fileName,
        ]);

        return response()->json([
            'message' => 'Data added successfully',
            'data' => new PernikahanResource($nikah)
        ], 200);
    }

    public function update(Request $request, Pernikahan $nikah) 
    {
        $validator = Validator::make($request->all(),[
                    'id_suami' => 'required|integer',
                    'id_istri' => 'required|integer',
                    'tempat_nikah' => 'required|string|max:255',
                    'id_wali' => 'required|integer',
                    'id_saksi' => 'required|integer',
                    'no_kk' => 'required|integer',
                    'id_pengajuan' => 'required|integer',
                    'tgl_terbit' => 'required|date',
                    'file_nikah' => 'required|mimes:jpg,jpeg,png,pdf',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be filled',
                'error' => $validator->messages(),
            ], 422);
        }

        $data = $request->only([
            'id_suami','id_istri','tempat_nikah','id_wali','id_saksi',
            'no_kk','id_pengajuan','tgl_terbit'
        ]);

        if ($request->hasFile('file_nikah')) {
            if ($nikah->file_nikah && Storage::exists('public/nikah/' . $nikah->file_nikah)) {
                Storage::delete('public/nikah/' . $nikah->file_nikah);
            }

            $file = $request->file('file_nikah');
            $fileName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->storeAs('public/nikah', $fileName);
            $data['file_nikah'] = $fileName;
        }

        $nikah->update($data);

        return response()->json([
            'message' => 'Data updated successfully',
            'data' => new PernikahanResource($nikah),
        ], 200);
    }

    public function destroy(Pernikahan $nikah) 
    {
        if ($nikah->file_nikah && Storage::exists('public/nikah/' . $nikah->file_nikah)) {
            Storage::delete('public/nikah/' . $nikah->file_nikah);
        }

        $nikah->delete();

        return response()->json([
            'message' => 'Data deleted successfully',
        ], 200);
    }
}
