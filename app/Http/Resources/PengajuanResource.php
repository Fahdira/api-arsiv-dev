<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PengajuanResource extends JsonResource
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
            'id_user' => $this->id_user,
            'id_jenis_pengajuan' => $this->id_jenis_pengajuan,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
