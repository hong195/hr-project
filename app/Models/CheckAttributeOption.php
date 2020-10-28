<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheckAttributeOption extends Model
{
    use HasFactory;

    protected $table = 'check_attribute_options';

    public $timestamps = false;

    public function attribute() : BelongsTo
    {
        return $this->belongsTo(CheckAttribute::class);
    }
}
