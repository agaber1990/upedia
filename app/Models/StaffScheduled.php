<?php

namespace App\Models;

use App\SmStaff;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffScheduled extends Model
{
    use HasFactory;

    // Add all fields that can be mass-assigned
    protected $fillable = [
        'category_id',
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

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function staff()
    {
        return $this->belongsTo(SmStaff::class, 'staff_id');
    }

    public function trackType()
    {
        return $this->belongsTo(TrackType::class, 'track_type_id');
    }

    public function track()
    {
        return $this->belongsTo(Track::class, 'track_id');
    }

    public function getSlotsAttribute()
    {
        $slotIds = json_decode($this->slot_id, true);
        if (is_array($slotIds) && count($slotIds) > 0) {
            return SlotEmp::whereIn('id', $slotIds)->get();
        }
        return collect();
    }

    // Manually fetch slots for compatibility with other logic
    public function slots()
    {
        return $this->getSlotsAttribute();
    }
}
