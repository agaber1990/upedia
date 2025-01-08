<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSepcialization extends Model
{
    use HasFactory;
    protected $table=['staff_sepcializations'];
    protected $fillable = ['levels','track_type_id','cat_id','track_id','staff_id'];

}
