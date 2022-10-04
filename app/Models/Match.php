<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    use HasFactory;

    public function participants()
    {
        return $this->hasMany(MatchParticipant::class);
    }

    public function enemy()
    {
        return $this->hasOne(MatchParticipant::class)->where('user_id', '!=', 3);
    }
}
