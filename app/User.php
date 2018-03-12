<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provider', 'provider_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    public static function getUserByProvider($provider, $provider_id)
    {
        return self::select('id')
            ->where('provider', $provider)
            ->where('provider_id', $provider_id)
            ->firstOrFail()
            ->id;
    }
}
