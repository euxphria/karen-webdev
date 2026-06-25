<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnrolledStudent extends Model
{
    protected $fillable = ['email', 'name', 'student_id', 'claimed', 'program', 'year'];
}
