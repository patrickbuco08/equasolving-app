<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserClassicModeDetail extends Model
{
    use HasFactory;

    protected $table = 'user_classic_mode_details';

    protected $fillable = [
        'user_id', 'current_level', 'trophies'
    ];

    protected $hidden = [
        'user_id', 'created_at', 'updated_at'
    ];
}
