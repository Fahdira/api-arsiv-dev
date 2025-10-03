<?php

namespace App\Models;

use App\Models\Pengajuan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisPengajuan extends Model
{
    use HasFactory;

    protected $table = 'jenis_pengajuan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_pengajuan'
    ];

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'id_jenis_pengajuan', 'id');
    }
}
