<?php

namespace App\Models;

use App\Casts\CastJsonAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheckData extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'value' => CastJsonAttribute::class,
    ];

    public function check(): BelongsTo
    {
        return $this->belongsTo(Check::class);
    }
}
