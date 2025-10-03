<?php

namespace App\Http\Controllers\Api;

use App\Models\Ijasah;
use Illuminate\Http\Request;
use App\Http\Resources\IjasahResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class IjasahController
{
    public function index()
    {
        $ijasah = Ijasah::get();
        if($ijasah->count() > 0) 
        {
            return IjasahResource::collection($ijasah);
        } 
        else 
        {
            return response()->json(['message' => 'Data not found'], 200);
        }
    }

    public function show(Ijasah $ijasah)
    {
        return new IjasahResource($ijasah);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                    'nim'       => 'required|integer',
                    'no_ijasah' => 'required|integer',
                    'nama'      => 'required|string|max:255',
                    'tmp_lhr'   => 'required|string|max:255',
                    'tgl_lhr'   => 'required|date',
                    'institusi' => 'required|string|max:255',
                    'thn_lulus' => 'required|integer|digits:4',
                    'jurusan'   => 'required|string|max:255',
                    'nilai'     => 'required|string|max:255',
                    'tgl_terbit' => 'required|date',
                    'id_pengajuan' => 'required|integer',
                    'file_ijasah' => 'required|mimes:jpg,jpeg,png,pdf',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be filled',
                'error' => $validator->messages(),
            ], 422);
        }

        $file = $request->file('file_ijasah');
        $fileName = time() . '_' . $file->getClientOriginalName();
        Storage::putFileAs('public/ijasah', $file, $fileName);

        $ijasah = Ijasah::create([
            'nim'       => $request->nim,
            'no_ijasah' => $request->no_ijasah,
            'nama'      => $request->nama,
            'tmp_lhr'   => $request->tmp_lhr,
            'tgl_lhr'   => $request->tgl_lhr,
            'institusi' => $request->institusi,
            'thn_lulus' => $request->thn_lulus,
            'jurusan'   => $request->jurusan,
            'nilai'     => $request->nilai,
            'tgl_terbit' => $request->tgl_terbit,
            'id_pengajuan' => $request->id_pengajuan,
            'file_ijasah' => $fileName,
        ]);

        return response()->json([
            'message' => 'Data added successfully',
            'data' => new IjasahResource($ijasah)
        ], 200);
    }

    public function update(Request $request, Ijasah $ijasah)
    {
        $validator = Validator::make($request->all(),[
                    'nim'       => 'sometimes|required|integer',
                    'no_ijasah' => 'sometimes|required|integer',
                    'nama'      => 'sometimes|required|string|max:255',
                    'tmp_lhr'   => 'sometimes|required|string|max:255',
                    'tgl_lhr'   => 'sometimes|required|date',
                    'institusi' => 'sometimes|required|string|max:255',
                    'thn_lulus' => 'sometimes|required|integer|digits:4',
                    'jurusan'   => 'sometimes|required|string|max:255',
                    'nilai'     => 'sometimes|required|string|max:255',
                    'tgl_terbit' => 'sometimes|required|date',
                    'id_pengajuan' => 'sometimes|required|integer',
                    'file_ijasah' => 'sometimes|required|mimes:jpg,jpeg,png,pdf',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be filled',
                'error' => $validator->messages(),
            ], 422);
        }

        $data = $request->only([
            'nim','no_ijasah', 'nama','tmp_lhr','tgl_lhr','institusi',
            'thn_lulus','jurusan','nilai','tgl_terbit',
            'id_pengajuan'
        ]);

        if ($request->hasFile('file_ijasah')) {
            if ($ijasah->file_ijasah && Storage::exists('public/ijasah/' . $ijasah->file_ijasah)) {
                Storage::delete('public/ijasah/' . $ijasah->file_ijasah);
            }

            $file = $request->file('file_ijasah');
            $fileName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->storeAs('public/ijasah', $fileName);
            $data['file_ijasah'] = $fileName;
        }

        $ijasah->update($data);

        return response()->json([
            'message' => 'Data updated successfully',
            'data' => new IjasahResource($ijasah),
        ], 200);
    }

    public function destroy(Ijasah $ijasah)
    {
        if ($ijasah->file_ijasah && Storage::exists('public/ijasah/' . $ijasah->file_ijasah)) {
            Storage::delete('public/ijasah/' . $ijasah->file_ijasah);
        }

        $ijasah->delete();

        return response()->json([
            'message' => 'Data deleted successfully',
        ], 200);
    }
}
