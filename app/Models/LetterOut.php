<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LetterOut extends Model
{
    use HasFactory;
    protected $table = 'letters_out';
    protected $guarded = ['id'];
    protected $fillable = [
        'tgl_surat', 'nomor_surat', 'no_agenda', 'pengirim', 
        'penerima', 'perihal', 'devisi', 'kode_klasifikasi', 'file_surat'
    ];

    public function divisi(): BelongsTo
    {
        return $this->belongsTo(Division::class, 'devisi', 'kode');
    }
    public function classification(): BelongsTo
    {
        return $this->belongsTo(Classification::class, 'kode_klasifikasi', 'kode');
    }
}
