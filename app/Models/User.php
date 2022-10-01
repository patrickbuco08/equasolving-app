<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_welcome_tutorial_finished', 'is_pvp_tutorial_finished', 'in_game'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ownedBackgrounds()
    {
        return $this->hasMany(GameBackground::class);
    }

    public function classicModeDetails()
    {
        return $this->hasOne(UserClassicModeDetail::class);
    }

    public function pvpModeDetails()
    {
        return $this->hasOne(UserPVPModeDetail::class);
    }

    public function matches()
    {
        // return $this->hasMany(Match::class, 'id', 'user_id');
        return $this->hasMany(MatchParticipant::class);
    }

}
