<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkeletonController extends Controller
{
    public function nickname()
    {
        return view('user-interface.skeleton.set-nickname');
    }

    public function classic()
    {
        return view('user-interface.skeleton.classic');
    }

    public function findMatch()
    {
        return view('user-interface.skeleton.find-match');
    }

    public function home()
    {
        return view('user-interface.skeleton.home');
    }

    public function matchHistory()
    {

        $user = auth()->user()->load([
            'matches',
            'pvpModeDetails',
            'matches.details',
            'matches.details.enemy',
            'matches.details.enemy.user' => function($query){
                $query->select('id', 'name', 'email');
            }]);

        return view('user-interface.skeleton.match-history', [
            'matches' => collect($user->matches)->slice(0, 10)->sortBy('created_at'),
            'user' => $user
        ]);
    }

    public function shop()
    {
        return view('user-interface.skeleton.shop');
    }

    public function versusScreen(Request $request)
    {
        $contestant_one = $request->first_contestant;
        $contestant_two = $request->second_contestant;

        return view('user-interface.skeleton.versus-screen', [
            'contestant_one' => $contestant_one,
            'contestant_two' => $contestant_two
        ]);
    }

    public function winLoseAnnouncement(Request $request)
    {
        $player = ($request->player_one['id'] == auth()->user()->id) ? $request->player_one : $request->player_two;

        return view('user-interface.skeleton.win-lose-announcement',[
            'player'=> $player,
            'isDraw' => $request->isDraw
        ]);
    }
}
