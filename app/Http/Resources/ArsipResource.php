<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArsipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'no_ktp' => $this->no_ktp,
            'no_kk' => $this->no_kk,
            'nama' => $this->nama,
            'tmp_lhr' => $this->tmp_lhr,
            'tgl_lhr' => $this->tgl_lhr,
            'alamat' => $this->alamat,
            'kelamin' => $this->kelamin,
            'agama' => $this->agama,
            'status_kawin' => $this->status_kawin,
            'pekerjaan' => $this->pekerjaan,
            'kewarganegaraan' => $this->kewarganegaraan,
            'gol_darah' => $this->gol_darah,
            'tgl_terbit' => $this->tgl_terbit,
            'tgl_berlaku' => $this->tgl_berlaku,
            'id_pengajuan' => $this->id_pengajuan,
            'file_ktp' => $this->file_ktp 
                ? asset('storage/ktp/' . $this->file_ktp) 
                : null,
            'file_kk' => $this->file_kk 
                ? asset('storage/kk/' . $this->file_kk) 
                : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
