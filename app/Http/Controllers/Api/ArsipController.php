<?php

namespace App\Http\Controllers\Api;

use App\Models\Arsip;
use Illuminate\Http\Request;
use App\Http\Resources\ArsipResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArsipController
{
    public function index()
    {
        $arsip = Arsip::get();
        if($arsip->count() > 0) 
        {
            return ArsipResource::collection($arsip);
        } 
        else 
        {
            return response()->json(['message' => 'Data not found'], 200);
        }
    }

    public function show(Arsip $arsip)
    {
        return new ArsipResource($arsip);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                    'no_ktp' => 'required|integer',
                    'no_kk' => 'required|integer',
                    'nama' => 'required|string|max:255',
                    'tmp_lhr' => 'required|string|max:255',
                    'tgl_lhr' => 'required|date',
                    'alamat' => 'required|string|max:255',
                    'kelamin' => 'required|string|max:255',
                    'agama' => 'required|string|max:255',
                    'status_kawin' => 'required|boolean',
                    'pekerjaan' => 'required|string|max:255',
                    'kewarganegaraan' => 'required|string|max:255',
                    'gol_darah' => 'required|string|max:255',
                    'tgl_terbit' => 'required|date',
                    'tgl_berlaku' => 'required|date',
                    'id_pengajuan' => 'required|integer',
                    'file_ktp' => 'required|mimes:jpg,jpeg,png,pdf',
                    'file_kk' => 'required|mimes:jpg,jpeg,png,pdf'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be filled',
                'error' => $validator->messages(),
            ], 422);
        }

        $fileKtp = $request->file('file_ktp');
        $fileNameKtp = time() . '_' . $fileKtp->getClientOriginalName();
        Storage::putFileAs('public/ktp', $fileKtp, $fileNameKtp);

        $fileKk = $request->file('file_kk');
        $fileNameKk = time() . '_' . $fileKk->getClientOriginalName();
        Storage::putFileAs('public/kk', $fileKk, $fileNameKk);

        $arsip = Arsip::create([
            'no_ktp' => $request->no_ktp,
            'no_kk' => $request->no_kk,
            'nama' => $request->nama,
            'tmp_lhr' => $request->tmp_lhr,
            'tgl_lhr' => $request->tgl_lhr,
            'alamat' => $request->alamat,
            'kelamin' => $request->kelamin,
            'agama' => $request->agama,
            'status_kawin' => $request->status_kawin,
            'pekerjaan' => $request->pekerjaan,
            'kewarganegaraan' => $request->kewarganegaraan,
            'gol_darah' => $request->gol_darah,
            'tgl_terbit' => $request->tgl_terbit,
            'tgl_berlaku' => $request->tgl_berlaku,
            'id_pengajuan' => $request->id_pengajuan,
            'file_ktp' => $fileNameKtp,
            'file_kk' => $fileNameKk,
        ]);

        return response()->json([
            'message' => 'Data added successfully',
            'data' => new ArsipResource($arsip)
        ], 200);
    }

    public function update(Request $request, Arsip $arsip)
    {
        $validator = Validator::make($request->all(), [
                'no_ktp'          => 'sometimes|required|integer',
                'no_kk'           => 'sometimes|required|integer',
                'nama'            => 'sometimes|required|string|max:255',
                'tmp_lhr'         => 'sometimes|required|string|max:255',
                'tgl_lhr'         => 'sometimes|required|date',
                'alamat'          => 'sometimes|required|string|max:255',
                'kelamin'         => 'sometimes|required|string|max:255',
                'agama'           => 'sometimes|required|string|max:255',
                'status_kawin'    => 'sometimes|required|boolean',
                'pekerjaan'       => 'sometimes|required|string|max:255',
                'kewarganegaraan' => 'sometimes|required|string|max:255',
                'gol_darah'       => 'sometimes|required|string|max:255',
                'tgl_terbit'      => 'sometimes|required|date',
                'tgl_berlaku'     => 'sometimes|required|date',
                'id_pengajuan'    => 'sometimes|required|integer',
                'file_ktp'        => 'sometimes|mimes:jpg,jpeg,png,pdf|max:2048',
                'file_kk'         => 'sometimes|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'error' => $validator->messages(),
            ], 422);
        }

        $data = $request->only([
            'no_ktp','no_kk','nama','tmp_lhr','tgl_lhr','alamat',
            'kelamin','agama','status_kawin','pekerjaan',
            'kewarganegaraan','gol_darah','tgl_terbit','tgl_berlaku',
            'id_pengajuan'
        ]);

        if ($request->hasFile('file_ktp')) {
            if ($arsip->file_ktp && Storage::exists('public/ktp/' . $arsip->file_ktp)) {
                Storage::delete('public/ktp/' . $arsip->file_ktp);
            }

            $fileKtp = $request->file('file_ktp');
            $fileNameKtp = time() . '_' . preg_replace('/\s+/', '_', $fileKtp->getClientOriginalName());
            $fileKtp->storeAs('public/ktp', $fileNameKtp);
            $data['file_ktp'] = $fileNameKtp;
        }

        if ($request->hasFile('file_kk')) {
            if ($arsip->file_kk && Storage::exists('public/kk/' . $arsip->file_kk)) {
                Storage::delete('public/kk/' . $arsip->file_kk);
            }

            $fileKk = $request->file('file_kk');
            $fileNameKk = time() . '_' . preg_replace('/\s+/', '_', $fileKk->getClientOriginalName());
            $fileKk->storeAs('public/kk', $fileNameKk);
            $data['file_kk'] = $fileNameKk;
        }

        $arsip->update($data);

        return response()->json([
            'message' => 'Data updated successfully',
            'data' => new ArsipResource($arsip),
        ], 200);
    }

    public function destroy(Arsip $arsip){
        if ($arsip->file_ktp && Storage::exists('public/ktp/' . $arsip->file_ktp)) {
            Storage::delete('public/ktp/' . $arsip->file_ktp);
        }
        if ($arsip->file_kk && Storage::exists('public/kk/' . $arsip->file_kk)) {
            Storage::delete('public/kk/' . $arsip->file_kk);
        }
        $arsip->delete();
        return response()->json([
            'message' => 'Data deleted successfully',
        ], 200);
    }
}
