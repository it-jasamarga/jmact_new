<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackContactTracker extends Model
{
    use HasFactory;
    protected $fillable = ['no_tiket', 'last_contact_at', 'last_contact_by'];
}
