<?php

namespace App\Models;

use App\Casts\CastJsonAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use function Opis\Closure\serialize;
use function Opis\Closure\unserialize;

class UserData extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'value' => CastJsonAttribute::class,
    ];

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
