<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'email', 'purpose', 'message', 'is_read'];

    protected $casts = ['created_at' => 'datetime'];
}