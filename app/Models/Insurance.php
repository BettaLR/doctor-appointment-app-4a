<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    protected $fillable = [
        'name',
        'policy_number',
        'coverage_type',
        'coverage_percentage',
        'contact_phone',
        'contact_email',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'coverage_percentage' => 'decimal:2',
    ];
}
