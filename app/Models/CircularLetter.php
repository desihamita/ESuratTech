<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CircularLetter extends Model
{
    use HasFactory;
    protected $table = 'circular_letter';
    protected $guarded = ['id'];
    protected $fillable = [
        'konten','letterout_id'
    ];

    public function letterOut(): BelongsTo
    {
        return $this->belongsTo(letterOut::class, 'letterout_id', 'id');
    }
}
