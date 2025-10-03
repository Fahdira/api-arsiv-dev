<?php

namespace App\Models;

use App\Models\Pengajuan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ijasah extends Model
{
    use HasFactory;

    protected $table = 'ijasah';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nim',
        'no_ijasah',
        'nama',
        'tmp_lhr',
        'tgl_lhr',
        'institusi',
        'thn_lulus',
        'jurusan',
        'nilai',
        'tgl_terbit',
        'id_pengajuan',
        'file_ijasah',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'id_pengajuan', 'id');
    }
}
