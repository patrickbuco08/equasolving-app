<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameBackground extends Model
{
    use HasFactory;

    protected $table = 'user_backgrounds';

    protected $fillable = [
        'background_id', 'activated'
    ];

    public function background()
    {
        return $this->hasOne(Background::class);
    }

}
