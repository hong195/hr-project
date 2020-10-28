<?php

namespace App\Models;

use App\Casts\CastJsonAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use function Opis\Closure\serialize;
use function Opis\Closure\unserialize;

class CheckAttribute extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'options' => CastJsonAttribute::class,
    ];

    public function options() : HasMany
    {
        return $this->hasMany(CheckAttributeOption::class);
    }
}
