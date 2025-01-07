<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmAcademyType extends Model
{
    use HasFactory;

    protected $table = 'em_academy_types';

    protected $fillable = ['name'];




}
