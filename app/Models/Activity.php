<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'description',
        'subject_type',
        'subject_id',
        'properties',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'properties' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->morphTo();
    }

    public function getIconBackground()
    {
        return match($this->type) {
            'create' => 'bg-green-500',
            'update' => 'bg-blue-500',
            'delete' => 'bg-red-500',
            default => 'bg-gray-500'
        };
    }

    public function getIcon()
    {
        return match($this->type) {
            'create' => 'fas fa-plus',
            'update' => 'fas fa-edit',
            'delete' => 'fas fa-trash',
            default => 'fas fa-info'
        };
    }
}
