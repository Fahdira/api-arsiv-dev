<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_jabatan'
    ];

    public function jabatan()
    {
        return $this->hasMany(Users::class, 'id_jabatan', 'id');
    }
}
