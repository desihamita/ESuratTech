<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratTugas extends Model
{
    use HasFactory;
    protected $table = 'assignment_letter';
    protected $guarded = ['id'];
    protected $fillable = [
        'nama', 'jabatan', 'tgl_acara', 'waktu', 'tempat', 'letterout_id'
    ];

    public function letterOut(): BelongsTo
    {
        return $this->belongsTo(letterOut::class, 'letterout_id', 'id');
    }
}
