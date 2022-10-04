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

    protected $hidden = [
        'user_id', 'created_at', 'updated_at'
    ];

    public function details()
    {
        return $this->hasOne(Background::class, 'id', 'background_id');
    }

}
