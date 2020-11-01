<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims() : array
    {
        return [];
    }

    public function checks() : HasMany
    {
        return $this->hasMany(Check::class);
    }

    public function pharmacy() : BelongsTo
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function meta() : HasMany
    {
        return $this->hasMany(UserData::class);
    }

    public function ratings() : HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getNameAttribute()
    {
        return "$this->first_name $this->last_name $this->patronymic";
    }

    public function hasRating($created_at) : bool
    {
        $created_at = $created_at instanceof Carbon ? $created_at : Carbon::parse($created_at);

        return $this->ratings()
            ->whereYear('created_at', $created_at->year)
            ->whereMonth('created_at', $created_at->month)
            ->exists();
    }
}
