<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Part extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'serialnumber',
        'quantity',   // ostáva v parts (1:N režim)
        'car_id',
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    // (voliteľné) vyhľadávanie
    public function scopeSearch($q, ?string $term) {
        return $term ? $q->where(fn($w)=>$w->where('name','like',"%$term%")->orWhere('serialnumber','like',"%$term%")) : $q;
    }
}
