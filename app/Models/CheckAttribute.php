<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CheckAttribute extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['options'];

    public function options() : HasMany
    {
        return $this->hasMany(CheckAttributeOption::class);
    }

    public function scopeUseInRating($query)
    {
        return $query->where('use_in_rating', true);
    }
}
