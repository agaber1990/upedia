<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingPlanType extends Model
{
    use HasFactory;
    protected $table = 'pricing_plan_types';

    protected $fillable = ['name'];

}
