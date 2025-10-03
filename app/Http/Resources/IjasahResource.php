<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IjasahResource extends JsonResource
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
            'nim' => $this->nim,
            'no_ijasah' => $this->no_ijasah,
            'nama' => $this->nama,
            'tmp_lhr' => $this->tmp_lhr,
            'tgl_lhr' => $this->tgl_lhr,
            'institusi' => $this->institusi,
            'thn_lulus' => $this->thn_lulus,
            'jurusan' => $this->jurusan,
            'nilai' => $this->nilai,
            'tgl_terbit' => $this->tgl_terbit,
            'id_pengajuan' => $this->id_pengajuan,
            'file_ijasah' => $this->file_ijasah 
                ? asset('storage/ijasah/' . $this->file_ijasah) 
                : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
