<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Match extends Model
{
    use HasFactory;

    protected $table = 'matches';

    protected $fillable = ['unique_id'];

    public function participants()
    {
        return $this->hasMany(MatchParticipant::class);
    }

    public function enemy()
    {
        return $this->hasOne(MatchParticipant::class)->where('user_id', '!=', auth()->user()->id);
    }
}
