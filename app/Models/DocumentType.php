<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $fillable = ['name', 'description', 'template_path', 'is_active'];

    public function documentRequests()
    {
        return $this->hasMany(DocumentRequest::class);
    }

    // Only return active types for dropdowns
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}