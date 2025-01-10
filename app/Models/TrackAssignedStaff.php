<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackAssignedStaff extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'staff_id',
        'cat_id',
        'track_type_id',
        'track_id',
        'levels',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'levels' => 'array', // Automatically casts the 'levels' column to an array
    ];

    /**
     * Define the relationship with the staff model.
     * Update this to the actual model name for staff.
     */
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    /**
     * Define the relationship with the category.
     * Update this to the actual model name for categories.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    /**
     * Define the relationship with the track.
     * Update this to the actual model name for tracks.
     */
    public function track()
    {
        return $this->belongsTo(Track::class, 'track_id');
    }

    /**
     * Define the relationship with the track type.
     * Update this to the actual model name for track types.
     */
    public function trackType()
    {
        return $this->belongsTo(TrackType::class, 'track_type_id');
    }
}
