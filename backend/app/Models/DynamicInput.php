<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DynamicInput extends Model
{
    protected $fillable = ['label', 'name', 'type', 'active', 'options'];

    protected $casts = [
        'options' => 'array',
        'active' => 'boolean',
    ];
}
