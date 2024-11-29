<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Disposisi extends Model
{
    use HasFactory;
    protected $table = 'dispositions';
    protected $fillable = [
        'letter_id',
        'penerima',
        'catatan',
        'status',
        'priority',
        'due_date',
    ];

    public function letter(): BelongsTo
    {
        return $this->belongsTo(Letter::class, 'letter_id', 'id'); 
    }
    
    public function divisi()
    {
        return $this->belongsTo(Division::class, 'penerima');
    }
}
