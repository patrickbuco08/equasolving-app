<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_welcome_tutorial_finished', 'is_pvp_tutorial_finished', 'is_google_account', 'in_game', 'room_id'
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

    public function selectedBackground()
    {
    
        $themes = [
            '1' => 'main-default',
            '2' => 'main-cloud',
            '3' => 'main-sun',
            '4' =>  'main-mid'
        ];
        $currentBG = $this->ownedBackgrounds()->where('activated', true)->first();

        return $themes[$currentBG->background_id];

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
        return $this->hasMany(MatchParticipant::class)->orderBy('created_at', 'DESC');
    }

}
