<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KeuanganResource extends JsonResource
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
            'no_spm' => $this->no_spm,
            'sp2d' => $this->sp2d,
            'tahun_anggaran' => $this->tahun_anggaran,
            'jenis' => $this->jenis,
            'bidang' => $this->bidang,
            'tgl_input' => $this->tgl_input,
            'jumlah_anggaran' => $this->jumlah_anggaran,
            'id_pengajuan' => $this->id_pengajuan,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
