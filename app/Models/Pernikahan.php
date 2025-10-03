<?php

namespace App\Models;

use App\Models\Arsip;
use App\Models\Pengajuan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pernikahan extends Model
{
    use HasFactory;

    protected $table = 'pernikahan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_suami',
        'id_istri',
        'tempat_nikah',
        'id_wali',
        'no_kk',
        'id_saksi',
        'tgl_terbit',
        'id_pengajuan',
        'file_nikah',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'id_pengajuan', 'id');
    }

    public function suami()
    {
        return $this->belongsTo(Arsip::class, 'id_pengajuan', 'id');
    }

    public function istri()
    {
        return $this->belongsTo(Arsip::class, 'id_pengajuan', 'id');
    }

    public function wali()
    {
        return $this->belongsTo(Arsip::class, 'id_pengajuan', 'id');
    }

    public function saksi()
    {
        return $this->belongsTo(Arsip::class, 'id_pengajuan', 'id');
    }
}
