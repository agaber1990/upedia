<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionLesson extends Model
{
    use HasFactory;
    protected $fillable = [
        'session_id',
        'level_id',
        'name',
        'duration',
        'privacy',
        'host_type',
        'host_path',
        'description',
    ];


    public function session()
    {
        return $this->belongsTo(TrackLevelSession::class, 'session_id');
    }
    public function level()
    {
        return $this->belongsTo(TrackLevel::class, 'level_id');
    }
}
