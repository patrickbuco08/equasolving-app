<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPVPModeDetail extends Model
{
    use HasFactory;

    protected $table = 'user_pvp_mode_details';

    protected $fillable = [
        'user_id', 'total_matches', 'winrate', 'mmr'
    ];

    protected $hidden = [
        'user_id', 'created_at', 'updated_at'
    ];

}
