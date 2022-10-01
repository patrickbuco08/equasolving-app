<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser(User $user){
        $user->load([
            'ownedBackgrounds',
            'ownedBackgrounds.details',
            'classicModeDetails',
            'pvpModeDetails',
            'matches',
            'matches.details',
            'matches.details.enemy',
            'matches.details.enemy.user' => function($query){
                $query->select('id', 'name', 'email');
            }]);

        return $user;
    }
}
