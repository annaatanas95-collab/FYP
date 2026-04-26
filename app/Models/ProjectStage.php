<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Stage;
use App\Models\Project;

class ProjectStage extends Model
{
    protected $fillable = [
        'project_id',
        'stage_id',
        'deliverable',
        'deadline',
        'is_open'
    ];

    // relation na stage
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    // relation na project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}