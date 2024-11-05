<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import untuk relasi

class Letter extends Model
{
    use HasFactory;

    protected $table = 'letters';
    protected $fillable = [
        'nomor_surat',          
        'no_agenda',           
        'pengirim',            
        'penerima',            
        'tgl_surat',           
        'tgl_diterima',        
        'perihal',             
        'file_surat',          
        'kode_klasifikasi',    
        'user_id',             
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function classification(): BelongsTo
    {
        return $this->belongsTo(Classification::class, 'kode_klasifikasi', 'kode');
    }
    public function dispositions(): HasMany
    {
        return $this->hasMany(Disposisi::class, 'letter_id', 'id');
    }
     
}
