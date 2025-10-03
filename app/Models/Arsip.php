<?php

namespace App\Models;

use App\Models\Kelahiran;
use App\Models\Pengajuan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Arsip extends Model
{
    use HasFactory;

    protected $table = 'arsip';
    protected $primaryKey = 'id';

    protected $fillable = [
        'no_ktp',
        'no_kk',
        'nama',
        'tmp_lhr',
        'tgl_lhr',
        'alamat',
        'kelamin',
        'agama',
        'status_kawin',
        'pekerjaan',
        'kewarganegaraan',
        'gol_darah',
        'tgl_terbit',
        'tgl_berlaku',
        'id_pengajuan',
        'file_ktp',
        'file_kk',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'id_pengajuan', 'id');
    }

    public function lahir_ayah()
    {
        return $this->hasMany(Kelahiran::class, 'id_ayah', 'id');
    }

    public function lahir_ibu()
    {
        return $this->hasMany(Kelahiran::class, 'id_ibu', 'id');
    }

    public function nikah_suami()
    {
        return $this->hasMany(Pernikahan::class, 'id_suami', 'id');
    }

    public function nikah_istri()
    {
        return $this->hasMany(Pernikahan::class, 'id_istri', 'id');
    }

    public function nikah_wali()
    {
        return $this->hasMany(Pernikahan::class, 'id_wali', 'id');
    }

    public function nikah_saksi()
    {
        return $this->hasMany(Pernikahan::class, 'id_saksi', 'id');
    }
}
