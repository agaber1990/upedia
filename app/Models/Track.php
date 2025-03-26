<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Track extends Model
{
    use HasFactory;

    protected $fillable = [
        'cat_id',
        'track_name_en',
        'track_name_ar',
        'level_number',
        'session',
        'schedule',
        'valid_for',
    ];

    public function levels()
    {
        return $this->belongsTo(Level::class, 'level_number');
    }

    public function track_pricing_plans()
    {
        return $this->hasMany(TrackPricingPlan::class);
    }

    public function staff_scheduled()
    {
        return $this->hasMany(StaffScheduled::class);
    }
}
