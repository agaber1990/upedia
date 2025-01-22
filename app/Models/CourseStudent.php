<?php

namespace App\Models;

use App\SmStudent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
    ];

    public function student()
    {
        return $this->belongsTo(SmStudent::class, 'student_id');
    }
    public function course()
    {
        return $this->belongsTo(StaffScheduled::class, 'course_id');
    }
}
