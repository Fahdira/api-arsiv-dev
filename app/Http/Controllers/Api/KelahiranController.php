<?php

namespace App\Http\Controllers\Api;

use App\Models\Kelahiran;
use Illuminate\Http\Request;
use App\Http\Resources\KelahiranResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KelahiranController
{
    public function index()
    {
        $lahir = Kelahiran::get();
        if($lahir->count() > 0) 
        {
            return KelahiranResource::collection($lahir);
        } 
        else 
        {
            return response()->json(['message' => 'Data not found'], 200);
        }
    }

    public function show(Kelahiran $lahir)
    {
        return new KelahiranResource($lahir);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                    'no_akta' => 'required|integer',
                    'nama' => 'required|string|max:255',
                    'tmp_lhr' => 'required|string|max:255',
                    'tgl_lhr' => 'required|date',
                    'alamat' => 'required|string|max:255',
                    'kelamin' => 'required|string|max:255',
                    'agama' => 'required|string|max:255',
                    'id_ayah' => 'required|integer',
                    'id_ibu' => 'required|integer',
                    'tgl_terbit' => 'required|date',
                    'id_pengajuan' => 'required|integer',
                    'file_akta' => 'required|mimes:jpg,jpeg,png,pdf',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be filled',
                'error' => $validator->messages(),
            ], 422);
        }

        $file = $request->file('file_akta');
        $fileName = time() . '_' . $file->getClientOriginalName();
        Storage::putFileAs('public/akta_lhr', $file, $fileName);

        $lahir = Kelahiran::create([
            'no_akta' => $request->no_akta,
            'nama' => $request->nama,
            'tmp_lhr' => $request->tmp_lhr,
            'tgl_lhr' => $request->tgl_lhr,
            'alamat' => $request->alamat,
            'kelamin' => $request->kelamin,
            'agama' => $request->agama,
            'id_ayah' => $request->id_ayah,
            'id_ibu' => $request->id_ibu,
            'tgl_terbit' => $request->tgl_terbit,
            'id_pengajuan' => $request->id_pengajuan,
            'file_akta' => $fileName,
        ]);

        return response()->json([
            'message' => 'Data added successfully',
            'data' => new KelahiranResource($lahir)
        ], 200);
    }

    public function update(Request $request, Kelahiran $lahir)
    {
        $validator = Validator::make($request->all(),[
                    'no_akta' => 'sometimes|required|integer',
                    'nama' => 'sometimes|required|string|max:255',
                    'tmp_lhr' => 'sometimes|required|string|max:255',
                    'tgl_lhr' => 'sometimes|required|date',
                    'alamat' => 'sometimes|required|string|max:255',
                    'kelamin' => 'sometimes|required|string|max:255',
                    'agama' => 'sometimes|required|string|max:255',
                    'id_ayah' => 'sometimes|required|integer',
                    'id_ibu' => 'sometimes|required|integer',
                    'tgl_terbit' => 'sometimes|required|date',
                    'id_pengajuan' => 'sometimes|required|integer',
                    'file_akta' => 'sometimes|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be filled',
                'error' => $validator->messages(),
            ], 422);
        }

        $data = $request->only([
            'no_akta','nama','tmp_lhr','tgl_lhr','alamat',
            'kelamin','agama','id_ayah','id_ibu','tgl_terbit',
            'id_pengajuan'
        ]);

        if ($request->hasFile('file_akta')) {
            if ($lahir->file_akta && Storage::exists('public/akta_lhr/' . $lahir->file_akta)) {
                Storage::delete('public/akta_lhr/' . $lahir->file_akta);
            }

            $file = $request->file('file_akta');
            $fileName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->storeAs('public/akta_lhr', $fileName);
            $data['file_akta'] = $fileName;
        }

        $lahir->update($data);

        return response()->json([
            'message' => 'Data updated successfully',
            'data' => new KelahiranResource($lahir),
        ], 200);
    }

    public function destroy(Kelahiran $lahir)
    {
        if ($lahir->file_akta && Storage::exists('public/akta_lhr/' . $lahir->file_akta)) {
            Storage::delete('public/akta_lhr/' . $lahir->file_akta);
        }

        $lahir->delete();

        return response()->json([
            'message' => 'Data deleted successfully',
        ], 200);
    }
}
