<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Match extends Model
{
    use HasFactory;

    protected $table = 'matches';

    public function participants()
    {
        return $this->hasMany(MatchParticipant::class);
    }

    public function carbonDate()
    {
        return $this->created_at;
        // $result = Carbon::createFromFormat('m/d/Y', $date)->diffForHumans();
    }


    public function enemy()
    {
        return $this->hasOne(MatchParticipant::class)->where('user_id', '!=', 3);
    }
}
