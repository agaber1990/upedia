<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackPricingPlan extends Model
{
    use HasFactory;
    protected $table = 'track_pricing_plans';
    protected $fillable = [
        'track_id',
        'pricing_plan_type_id',
        'track_type_id',
        'price',
    ];
}
