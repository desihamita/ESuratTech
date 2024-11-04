<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;
    protected $table = 'dispositions';
    protected $fillable = ['letter_id', 'penerima', 'catatan', 'status'];
}
