<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use function Opis\Closure\serialize;
use function Opis\Closure\unserialize;

class CheckAttribute extends Model
{
    use HasFactory;

    /**
     * @param $value
     * @return mixed
     */
    public function setOptionsAttribute($value) : void
    {
        $this->attributes['options'] = json_encode($value);
    }

    /**
     * @return mixed
     */
    public function getOptionsAttribute()  {
        return json_decode($this->attributes['options'], true);
    }
}
