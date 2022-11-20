<?php

namespace App\Http\Controllers;

use App\Models\Background;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkeletonController extends Controller
{

    public function home()
    {
        return view('user-interface.skeleton.home');
    }

    public function loader($text)
    {
        return view('user-interface.skeleton.loader', [
            'text' => $text
        ]);
    }

    public function nickname()
    {
        return view('user-interface.skeleton.set-nickname');
    }

    public function classic()
    {
        return view('user-interface.skeleton.classic');
    }

    public function classicSummary($level, $trophies)
    {
        $userClassicModeDetails = auth()->user()->classicModeDetails;

        $userClassicModeDetails->update([
            'current_level' => $level > $userClassicModeDetails->current_level ? $level : $userClassicModeDetails->current_level,
            'trophies' => $userClassicModeDetails->trophies + $trophies
        ]);

        return view('user-interface.skeleton.classic-summary', [
            'level' => $level,
            'trophies' => $trophies
        ]);
    }

    public function findMatch()
    {
        return view('user-interface.skeleton.find-match');
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
            'matches' => collect($user->matches)->slice(0, 10),
            'user' => $user
        ]);
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

        return view('user-interface.skeleton.shop', [
            'backgrounds' => $backgrounds 
        ]);
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
