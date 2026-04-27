<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    protected $fillable = [
        'resident_code', 'first_name', 'middle_name', 'last_name', 'suffix',
        'birthdate', 'gender', 'civil_status', 'purok_zone', 'address',
        'contact_number', 'email', 'profile_picture',
        'is_voter', 'is_senior_citizen', 'is_pwd', 'is_solo_parent', 'is_active',
    ];

    protected $casts = ['birthdate' => 'date'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function documentRequests()
    {
        return $this->hasMany(DocumentRequest::class);
    }

    // Computed: full name
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name} {$this->suffix}");
    }

    // Computed: age from birthdate
    public function getAgeAttribute(): int
    {
        return $this->birthdate->age;
    }
}