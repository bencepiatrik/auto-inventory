<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'registration_number',
        'is_registered',
    ];

    protected $casts = [
        'is_registered' => 'boolean',
    ];

    public function parts(): HasMany
    {
        return $this->hasMany(Part::class);
    }
}
