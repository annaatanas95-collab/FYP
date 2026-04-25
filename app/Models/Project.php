<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'student_id',
        'title',
        'status'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}

