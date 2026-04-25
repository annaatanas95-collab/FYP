<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Project;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'registration_number',
        'password',
        'role',
        'must_change_password',
        'supervisor_name',
        'supervisor_id'
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast attributes
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'must_change_password' => 'boolean',
        ];
    }

    // ================= RELATIONSHIPS =================

    /**
     * Student → Supervisor
     */
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    /**
     * Supervisor → Students
     */
    public function students()
    {
        return $this->hasMany(User::class, 'supervisor_id');
    }

    /**
     * Student → Project (Title)
     */
    public function project()
    {
        return $this->hasOne(Project::class, 'student_id');
    }

    /**
     * Helper: check role
     */
    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function isSupervisor()
    {
        return $this->role === 'supervisor';
    }

    public function isCoordinator()
    {
        return $this->role === 'coordinator';
    }
}

