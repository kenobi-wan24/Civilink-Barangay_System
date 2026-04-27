<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'resident_id', 'name', 'email', 'password', 'role', 'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    public function approvedRequests()
    {
        return $this->hasMany(DocumentRequest::class, 'approved_by');
    }

    public function releasedRequests()
    {
        return $this->hasMany(DocumentRequest::class, 'released_by');
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'posted_by');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    // Role helpers — use these in Blade and controllers
    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isStaff(): bool    { return $this->role === 'staff'; }
    public function isCaptain(): bool  { return $this->role === 'captain'; }
    public function isResident(): bool { return $this->role === 'resident'; }

    public function isAdminOrStaff(): bool
    {
        return in_array($this->role, ['admin', 'staff', 'captain']);
    }
}