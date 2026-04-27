<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    public $timestamps = false; // only has created_at, no updated_at

    protected $fillable = [
        'user_id', 'action', 'model_type', 'model_id', 'description',
    ];

    protected $casts = ['created_at' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Call this anywhere to log an action
    public static function record(string $action, string $description, $model = null): void
    {
        static::create([
            'user_id'     => auth()->id(),
            'action'      => $action,
            'model_type'  => $model ? class_basename($model) : null,
            'model_id'    => $model?->id,
            'description' => $description,
        ]);
    }
}