<?php

namespace App\Models;

use App\Models\Arsip;
use App\Models\Pengajuan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelahiran extends Model
{
    use HasFactory;

    protected $table = 'kelahiran';
    protected $primaryKey = 'id';

    protected $fillable = [
        'no_akta',
        'nama',
        'tmp_lhr',
        'tgl_lhr',
        'alamat',
        'kelamin',
        'agama',
        'id_ayah',
        'id_ibu',
        'tgl_terbit',
        'id_pengajuan',
        'file_akta',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'id_pengajuan', 'id');
    }

    public function ayah()
    {
        return $this->belongsTo(Arsip::class, 'id_ayah', 'id');
    }

    public function ibu()
    {
        return $this->belongsTo(Arsip::class, 'id_ibu', 'id');
    }
}
