<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembaga extends Model
{
    use HasFactory;
    protected $table = 'lembaga';

    protected $fillable = [
        'nama_lembaga',
        'telepon',
        'website',
        'email',
        'alamat',
        'tahun',
        'kota',
        'provinsi',
        'kepala',
        'nip',
        'jabatan',
        'logo',
    ];    
}
