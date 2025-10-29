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
        'registration_number', // môže byť null, ak nie je registrované
        'is_registered',
    ];

    protected $casts = [
        'is_registered' => 'boolean',
    ];

    public function parts(): HasMany
    {
        return $this->hasMany(Part::class);
    }

    // (voliteľné) pomocné scope-y pre filtery
    public function scopeRegistered($q, ?bool $v = true) { return $v === null ? $q : $q->where('is_registered', $v); }
    public function scopeSearch($q, ?string $term) {
        return $term ? $q->where(fn($w)=>$w->where('name','like',"%$term%")->orWhere('registration_number','like',"%$term%")) : $q;
    }
}
