<?php

namespace App\Http\Controllers\Api;

use App\Models\Kematian;
use Illuminate\Http\Request;
use App\Http\Resources\KematianResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KematianController
{
    public function index()
    {
        $mati = Kematian::get();
        if($mati->count() > 0) 
        {
            return KematianResource::collection($mati);
        } 
        else 
        {
            return response()->json(['message' => 'Data not found'], 200);
        }
    }

    public function show(Kematian $mati)
    {
        return new KematianResource($mati);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                    'no_akta'       => 'required|integer',
                    'nama'          => 'required|string|max:255',
                    'tmp_mati'      => 'required|string|max:255',
                    'tgl_mati'      => 'required|date',
                    'alamat'        => 'required|string|max:255',
                    'kelamin'       => 'required|string|max:255',
                    'agama'         => 'required|string|max:255',
                    'id_ayah'       => 'required|integer',
                    'id_ibu'        => 'required|integer',
                    'tgl_terbit'    => 'required|date',
                    'id_pengajuan'  => 'required|integer',
                    'file_akta'     => 'required|mimes:jpg,jpeg,png,pdf',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be filled',
                'error' => $validator->messages(),
            ], 422);
        }

        $file = $request->file('file_akta');
        $fileName = time() . '_' . $file->getClientOriginalName();
        Storage::putFileAs('public/akta_mati', $file, $fileName);

        $mati = Kematian::create([
            'no_akta'       => $request->no_akta,
            'nama'          => $request->nama,
            'tmp_mati'      => $request->tmp_mati,
            'tgl_mati'      => $request->tgl_mati,
            'alamat'        => $request->alamat,
            'kelamin'       => $request->kelamin,
            'agama'         => $request->agama,
            'id_ayah'       => $request->id_ayah,
            'id_ibu'        => $request->id_ibu,
            'tgl_terbit'    => $request->tgl_terbit,
            'id_pengajuan'  => $request->id_pengajuan,
            'file_akta'     => $fileName,
        ]);

        return response()->json([
            'message' => 'Data added successfully',
            'data' => new KematianResource($mati)
        ], 200);
    }

    public function update(Request $request, Kematian $mati)
    {
        $validator = Validator::make($request->all(),[
                'no_akta'       => 'sometimes|required|integer',
                'nama'          => 'sometimes|required|string|max:255',
                'tmp_mati'      => 'sometimes|required|string|max:255',
                'tgl_mati'      => 'sometimes|required|date',
                'alamat'        => 'sometimes|required|string|max:255',
                'kelamin'       => 'sometimes|required|string|max:255',
                'agama'         => 'sometimes|required|string|max:255',
                'id_ayah'       => 'sometimes|required|integer',
                'id_ibu'        => 'sometimes|required|integer',
                'tgl_terbit'    => 'sometimes|required|date',
                'id_pengajuan'  => 'sometimes|required|integer',
                'file_akta'     => 'sometimes|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be filled',
                'error' => $validator->messages(),
            ], 422);
        }

        $data = $request->only([
            'no_akta','nama','tmp_mati','tgl_mati','alamat',
            'kelamin','agama','id_ayah','id_ibu','tgl_terbit',
            'id_pengajuan'
        ]);

        if ($request->hasFile('file_akta')) {
            if ($mati->file_akta && Storage::exists('public/akta_mati/' . $mati->file_akta)) {
                Storage::delete('public/akta_mati/' . $mati->file_akta);
            }

            $file = $request->file('file_akta');
            $fileName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->storeAs('public/akta_mati', $fileName);
            $data['file_akta'] = $fileName;
        }

        $mati->update($data);

        return response()->json([
            'message' => 'Data updated successfully',
            'data' => new KematianResource($mati),
        ], 200);
    }

    public function destroy(Kematian $mati)
    {
        if ($mati->file_akta && Storage::exists('public/akta_mati/' . $mati->file_akta)) {
            Storage::delete('public/akta_mati/' . $mati->file_akta);
        }

        $mati->delete();

        return response()->json([
            'message' => 'Data deleted successfully',
        ], 200);
    }
}
