<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionLesson extends Model
{
    use HasFactory;
    protected $fillable = [
        'session_id',
        'name',
        'duration',
        'duration',
        'privacy',
        'host_type',
        'hose_path',
        'description',
    ];

    
}
