<?php

namespace App\Models;

use App\SmStaff;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSlot extends Model
{
    use HasFactory;
    protected $table = 'staff_slots';

    protected $fillable = ['staff_id', 'slot_id'];


    public function slotEmp()
    {
        return $this->belongsTo(SlotEmp::class, 'slot_id'); // 'slot_id' is the foreign key
    }
    public function slotStaff()
    {
        return $this->belongsTo(SmStaff::class, 'staff_id'); // 'staff_id' is the foreign key
    }
}
