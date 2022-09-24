<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchParticipant extends Model
{
    use HasFactory;

    protected $table = 'match_participants';

    protected $fillable = [
        'user_id', 'score', 'status'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

}
