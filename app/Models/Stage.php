<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectStage;

class Stage extends Model
{
    protected $fillable = [
        'name',
        'order'
    ];

    // relation na project_stages
    public function projectStages()
    {
        return $this->hasMany(ProjectStage::class);
    }
}