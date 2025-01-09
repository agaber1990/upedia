<?php

namespace App\Models;

use App\SmStaff;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecializationsStaff extends Model
{
    use HasFactory;

    protected $fillable = [
        'levels',
        'track_type_id',
        'cat_id',
        'track_id',
        'staff_id'
    ];


    public function staff()
{
    return $this->belongsTo(SmStaff::class, 'staff_id');
}
}
