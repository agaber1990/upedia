<?php

namespace App\Models;

use App\SmStudent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanaceStudentInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_scheduleds_id',
        'student_id',
        'invoice_number',
        'levels_id',
        'payment_status',
        'bill_status',
        'delivery_note',
    ];

    public function student()
    {
        return $this->belongsTo(SmStudent::class, 'student_id');
    }

    public function levels()
    {
        return $this->belongsTo(Level::class, 'levels_id');
    }
    public function staff_scheduled()
    {
        return $this->belongsTo(StaffScheduled::class, 'staff_scheduleds_id');
    }
}
