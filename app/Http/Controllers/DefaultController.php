<?php

namespace App\Http\Controllers;

use App\Models\Match;
use App\Models\Background;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DefaultController extends Controller
{
    public function index()
    {
        if(!Auth::check()){
            return view('user-interface.set-nickname');
        }
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
            // return $user->matches[0];
        return view('user-interface.match-history', [
            'matches' => collect($user->matches)->slice(0, 10)->sortBy('created_at')
        ]);
    }

    public function settings()
    {
        return view('user-interface.settings');
    }

    public function shop()
    {
        
        $userBackgrounds = auth()->user()->ownedBackgrounds;
        $backgrounds = Background::all();


        foreach ($backgrounds as $background) {
            if($userBackgrounds->contains('background_id', $background->id)){
                $background->isOwned = true;

                $userBackground = $userBackgrounds->where('background_id', $background->id)->first();

                if($userBackground->activated){
                    $background->isActivated = true;
                }else{
                    $background->isActivated = false;
                }

            }else{
                $background->isOwned = false;
                $background->isActivated = false;
            }
        }
        
        return view('user-interface.shop', [
            'backgrounds' => $backgrounds
        ]);
    }

    public function classic()
    {
        return view('user-interface.classic', [
            'textLoader' => 'Classic Mode Loading'
        ]);
    }

    public function pvp()
    {
        return view('user-interface.pvp');
    }

    public function findMatch()
    {
        $isAuthenticated = auth()->user()->is_google_account ? true : false;
        return view('user-interface.find-match', [
            'isAuthenticated' => $isAuthenticated
        ]);
    }

    public function versusScreen(Request $request)
    {
        return view('user-interface.versus-screen');
    }

}
