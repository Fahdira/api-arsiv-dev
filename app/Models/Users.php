<?php

namespace App\Models;

use App\Models\Pengajuan;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Users extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'email',
        'nama',
        'NIK',
        'username',
        'id_jabatan',
        'password',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id');
    }

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'id_user', 'id');
    }
}