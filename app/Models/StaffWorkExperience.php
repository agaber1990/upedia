<?php

namespace App\Models;

use App\SmStaff;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffWorkExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'company_name',
        'title',
        'from',
        'to',
    ];

    public function staff()
    {
        return $this->belongsTo(SmStaff::class, 'staff_id');
    }
}
