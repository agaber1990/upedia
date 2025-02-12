<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackSessionLevel extends Model
{
    use HasFactory;
    protected $fillable = [
        'track_id',
        'level_id',
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'file'
    ];
    protected $casts = [
        'file' => 'array',
    ];
    public function track()
    {
        return $this->belongsTo(Track::class, 'track_id');
    }
    public function level()
    {
        return $this->belongsTo(TrackLevel::class, 'level_id');
    }

    public function SessionLessons()
    {
        return $this->hasMany(SessionLesson::class);
    }
    public function SessionQuizzes()
    {
        return $this->hasMany(SessionQuiz::class, 'session_id');
    }
}
