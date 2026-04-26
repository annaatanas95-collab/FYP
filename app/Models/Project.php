<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ProjectStage;

class Project extends Model
{
    protected $fillable = [
        'student_id',
        'title',
        'status'
    ];

    // relation na student
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function stages()
    {
        return $this->hasMany(ProjectStage::class);
    }
}