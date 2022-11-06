<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DefaultController extends Controller
{
    public function index()
    {
        return view('user-interface.welcome');
    }

    public function userProfile()
    {
        return view('user-interface.user-profile');
    }

    public function matchHistory()
    {
        if(!Auth::check()){
            Auth::loginUsingId(4, $remember = true);
        }
        $user = auth()->user()->load([
            'matches',
            'matches.details',
            'matches.details.enemy',
            'matches.details.enemy.user' => function($query){
                $query->select('id', 'name', 'email');
            }]);
            //return $user->matches[0]->details;
        return view('user-interface.match-history', [
            'matches' => collect($user->matches)->slice(0, 10)
        ]);
    }

    public function settings()
    {
        return view('user-interface.settings');
    }

    public function classic()
    {
        return view('user-interface.classic');
    }

    public function pvp()
    {
        return view('user-interface.pvp');
    }

}
