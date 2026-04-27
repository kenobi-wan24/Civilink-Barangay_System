<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    protected $fillable = [
        'request_code', 'resident_id', 'document_type_id', 'purpose', 'status',
        'approved_by', 'released_by', 'approved_at', 'released_at',
        'admin_notes', 'generated_file', 'requested_at',
    ];

    protected $casts = [
        'approved_at'  => 'datetime',
        'released_at'  => 'datetime',
        'requested_at' => 'datetime',
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function releasedBy()
    {
        return $this->belongsTo(User::class, 'released_by');
    }

    // Status badge color helper — use in Blade
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'  => 'warning',
            'approved' => 'info',
            'released' => 'success',
            'rejected' => 'danger',
            default    => 'secondary',
        };
    }
}