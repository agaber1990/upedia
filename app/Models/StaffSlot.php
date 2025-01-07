<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSlot extends Model
{
    use HasFactory;
    protected $table = 'staff_slots';

    protected $fillable = ['staff_id','slot_id'];


}
