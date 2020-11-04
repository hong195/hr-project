<?php

namespace App\Models;

use App\Casts\CastJsonAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pharmacy extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
      'coordinates' => CastJsonAttribute::class,
    ];

    public function users() : HasMany
    {
        return $this->hasMany(User::class);
    }

    public function ratings()
    {
        return $this->hasManyThrough(Rating::class, User::class);
    }
}
