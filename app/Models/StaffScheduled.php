<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffScheduled extends Model
{
    use HasFactory;

    protected $fillable = [
        'slot_id','staff_id', 'fromDate', 'toDate','status'
    ];

}