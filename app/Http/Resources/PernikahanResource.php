<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PernikahanResource extends JsonResource
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
            'id_suami' => $this->id_suami,
            'id_istri' => $this->id_istri,
            'tempat_nikah' => $this->tempat_nikah,
            'id_wali' => $this->id_wali,
            'id_saksi' => $this->id_saksi,
            'no_kk' => $this->no_kk,
            'tgl_terbit' => $this->tgl_terbit,
            'id_pengajuan' => $this->id_pengajuan,
            'file_nikah' => $this->file_nikah 
                ? asset('storage/nikah/' . $this->file_nikah) 
                : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
