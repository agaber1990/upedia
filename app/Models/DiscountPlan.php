<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountPlan extends Model
{
    use HasFactory;

    protected $table = 'discount_plans';

    protected $casts = [
        'levels_prices' => 'array',
    ];

    protected $fillable = [
        'name_ar',
        'name_en',
        'levels_prices'
    ];

    public function levels()
    {
        return $this->belongsTo(Level::class, 'levels_prices');
    }
}
