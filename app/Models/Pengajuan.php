<?php

namespace App\Models;

use App\Models\Arsip;
use App\Models\Users;
use App\Models\Ijasah;
use App\Models\Kematian;
use App\Models\Kelahiran;
use App\Models\JenisPengajuan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_user',
        'id_jenis_pengajuan',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'id_user', 'id');
    }

    public function jenis()
    {
        return $this->belongsTo(JenisPengajuan::class, 'id_jenis_pengajuan', 'id');
    }

    public function pengajuan_arsip()
    {
        return $this->hasMany(Arsip::class, 'id_pengajuan', 'id');
    }

    public function pengajuan_lahir()
    {
        return $this->hasMany(Kelahiran::class, 'id_pengajuan', 'id');
    }

    public function pengajuan_mati()
    {
        return $this->hasMany(Kematian::class, 'id_pengajuan', 'id');
    }
    
    public function pengajuan_ijasah()
    {
        return $this->hasMany(Ijasah::class, 'id_pengajuan', 'id');
    }

    public function pengajuan_nikah()
    {
        return $this->hasMany(Pernikahan::class, 'id_pengajuan', 'id');
    }
}
