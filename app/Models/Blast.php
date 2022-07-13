<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blast extends Model
{
    use HasFactory;
    protected $fillable = ['no_telepon', 'nama', 'no_tiket', 'attributes', 'blast_state', 'blast_text'];
}
