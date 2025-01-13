<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountPlan extends Model
{
    use HasFactory;

    protected $table = 'discount_plans';
    protected $fillable = ['percentage',  'level_id'];

}
