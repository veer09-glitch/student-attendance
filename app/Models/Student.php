<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // fields that can be filled from a form
    protected $fillable = ['roll_no', 'name', 'class'];

    // one student has many attendance records
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}