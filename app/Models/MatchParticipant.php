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

    protected $hidden = [
        'id', 'match_id', 'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->belongsTo(Match::class, 'match_id', 'id');
    }
}
