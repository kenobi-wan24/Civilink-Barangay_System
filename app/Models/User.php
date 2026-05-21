<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        // Original fields
        'resident_id',
        'name',
        'email',
        'password',
        'role',
        'is_active',

        // Account status (pending / active / rejected)
        'account_status',
        'rejection_reason',

        // Registration personal info fields
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'birthdate',
        'reg_gender',
        'reg_civil_status',
        'reg_contact',
        'reg_purok_zone',
        'reg_address',
        'valid_id_path',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthdate'         => 'date',
    ];

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

    // Role helpers
    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isStaff(): bool    { return $this->role === 'staff'; }
    public function isCaptain(): bool  { return $this->role === 'captain'; }
    public function isResident(): bool { return $this->role === 'resident'; }

    public function isAdminOrStaff(): bool
    {
        return in_array($this->role, ['admin', 'staff', 'captain']);
    }

    // Account status helpers
    public function isPending(): bool  { return $this->account_status === 'pending'; }
    public function isApproved(): bool { return $this->account_status === 'active'; }
    public function isRejected(): bool { return $this->account_status === 'rejected'; }
}