<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory;
    protected $table = 'divisions';
    protected $fillable = [
        'kode',
        'nama',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'division_kode', 'kode');
    }
}
