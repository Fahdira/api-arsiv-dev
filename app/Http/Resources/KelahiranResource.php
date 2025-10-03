<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KelahiranResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'no_akta' => $this->no_akta,
            'nama' => $this->nama,
            'tmp_lhr' => $this->tmp_lhr,
            'tgl_lhr' => $this->tgl_lhr,
            'alamat' => $this->alamat,
            'kelamin' => $this->kelamin,
            'agama' => $this->agama,
            'tgl_terbit' => $this->tgl_terbit,
            'id_ayah' => $this->id_ayah,
            'id_ibu' => $this->id_ibu,
            'id_pengajuan' => $this->id_pengajuan,
            'file_akta' => $this->file_akta 
                ? asset('storage/akta_lhr/' . $this->file_akta) 
                : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
