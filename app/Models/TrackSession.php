<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackSession extends Model
{
    use HasFactory;
    protected $fillable = [
        'track_id',
        'level_id',
        'session_name_en',
        'session_name_ar',
        'session_number',
        'session_ref'
    ];

    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    public function level()
    {
        return $this->belongsTo(level::class);
    }
}
