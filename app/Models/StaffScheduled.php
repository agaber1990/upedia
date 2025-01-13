<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffScheduled extends Model
{
    use HasFactory;

    // Add all fields that can be mass-assigned
    protected $fillable = [
        'cat_id',
        'course_name_en',
        'course_name_ar',
        'slot_id',
        'staff_id',
        'status',
        'session',
        'schedule',
        'start_date',
        'end_date',
        'track_type_id',
        'track_id',
    ];

   
}
