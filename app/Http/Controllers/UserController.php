<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Match;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function checkIfAuthenticated()
    {
      $status_code = 401;
      $user = null;

      if(Auth::check()){
        $status_code = 200;
        $user = auth()->user();
      }

      return response()->json($user, $status_code);
      
    }

    public function getUser(User $user){
        $sql = "SELECT * FROM users where ?";

        $users = User::get();

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
