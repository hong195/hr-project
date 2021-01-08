<?php

namespace App\Models;

use App\Casts\CastJsonAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Check extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id', 'reviewer_id', 'criteria', 'sum', 'created_at'];

    protected $casts = [
        'criteria' => CastJsonAttribute::class
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer() : BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function meta() : HasMany
    {
        return $this->hasMany(CheckData::class);
    }

    public function ratings() : BelongsToMany
    {
        return $this->belongsToMany(Rating::class);
    }
}
