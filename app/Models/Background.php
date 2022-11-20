<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Background extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'css_theme', 'theme_id', 'price'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

}
