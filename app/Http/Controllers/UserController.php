<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Match;
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

    public function getMatchHistory(User $user){
        $user->load([
            'matches',
            'matches.details',
            'matches.details.enemy',
            'matches.details.enemy.user' => function($query){
                $query->select('id', 'name', 'email');
            }]);

        return $user;
    }

    public function getMatchHistoryv2($id)
    {
        $matches = Match::whereHas('participants', function($query) use($id){
            $query->where('user_id', $id);
        })->get();
        return $matches->load('participants', 'participants.user:id,name,email');
    }


}
