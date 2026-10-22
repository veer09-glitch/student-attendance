<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['student_id', 'subject_id', 'date', 'status'];

    // each attendance record belongs to one student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // and to one subject
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}