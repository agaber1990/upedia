<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlotEmp extends Model
{
    use HasFactory;

    protected $fillable = [
        'slot_day',
        'slot_start',
        'slot_end',
    ];

}
