<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    use HasFactory;

    protected $table = 'pricing_plans';

    protected $fillable = ['name', 'types', 'pricing_plan'];



    public function types()
    {
        return $this->belongsTo(EmType::class, 'types');
    }

    public function pricing_plan()
    {
        return $this->belongsTo(PricingPlanType::class, 'pricing_plan');
    }


}
