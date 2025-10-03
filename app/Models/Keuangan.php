<?php

namespace App\Models;

use App\Models\Pengajuan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keuangan extends Model
{
    use HasFactory;

    protected $table = 'keuangan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'no_spm',
        'sp2d',
        'tahun_anggaran',
        'jenis',
        'bidang',
        'tgl_input',
        'jumlah_anggaran',
        'id_pengajuan',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'id_pengajuan', 'id');
    }
}
