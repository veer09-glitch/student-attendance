<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'code'];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}