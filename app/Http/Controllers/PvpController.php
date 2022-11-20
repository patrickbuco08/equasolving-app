<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Match;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PvpController extends Controller
{
    public function setMatch(Request $request)
    {
        sleep(3);
        try {
            DB::beginTransaction();

            $match = Match::create([
                'unique_id' => $request->room_id
            ]);
    
            $player_one = User::find($request->first_contestant['id']);
            $player_two = User::find($request->second_contestant['id']);
    
            $player_one->update([
                'in_game' => true,
                'room_id' => $request->room_id
            ]);
    
            $player_two->update([
                'in_game' => true,
                'room_id' => $request->room_id
            ]);
    
            DB::commit();
            return response()->json([
                'player_one' => $player_one,
                'player_two'=> $player_two
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json($th, 409);
        }
    }

    public function saveMatch(Request $request)
    {
        // return $request->all();
        try {
            DB::beginTransaction();

            $roomID = $request->room_id;
            // $roomID = '636fa939cab49';
            $match = Match::where('unique_id', $roomID)->first();
            $data = $this->computePlayerData($request);

            $match->participants()->createMany([
                [
                    'user_id' => $data['contestant_one']['id'],
                    'score' => $data['contestant_one']['points'],
                    'status' => $data['contestant_one']['isWinner']
                ],
                [
                    'user_id' => $data['contestant_two']['id'],
                    'score' => $data['contestant_two']['points'],
                    'status' => $data['contestant_two']['isWinner']
                ]
            ]);

            // for player one
            $player_one = User::find($data['contestant_one']['id']);
            $player_one->update([
                'in_game' => false,
                'room_id' => null
            ]);

            $player_one_pvp_mode_details = $player_one->pvpModeDetails;
            $player_one_winrate = 0;
            $player_one_total_matches = $player_one_pvp_mode_details->total_matches; //7
            $player_one_current_winrate = $player_one_pvp_mode_details->winrate; //71%
            $player_one_total_wins = round($player_one_total_matches*($player_one_current_winrate/100)); // 7*.71 = 4.97 = 5


            if($data['contestant_one']['isWinner']){
                $player_one_winrate = ($player_one_total_wins+1)/($player_one_total_matches+1);
            }else{
                $player_one_winrate = $player_one_total_wins/($player_one_total_matches+1);
            }

            $player_one_pvp_mode_details->update([
                'total_matches' => $player_one_pvp_mode_details->total_matches + 1,
                'winrate' => $data['draw'] ? $player_one_pvp_mode_details->winrate : round($player_one_winrate*100),
                'mmr' => $data['contestant_one']['updated_mmr']
            ]);

            // for player two
            $player_two = User::find($data['contestant_two']['id']);
            $player_two->update([
                'in_game' => false,
                'room_id' => null
            ]);

            $player_two_pvp_mode_details = $player_two->pvpModeDetails;
            $player_two_winrate = 0;
            $player_two_total_matches = $player_two_pvp_mode_details->total_matches; //7
            $player_two_current_winrate = $player_two_pvp_mode_details->winrate; //71%
            $player_two_total_wins = round($player_two_total_matches*($player_two_current_winrate/100)); // 7*.71 = 4.97 = 5


            if($data['contestant_two']['isWinner']){
                $player_two_winrate = ($player_two_total_wins+1)/($player_two_total_matches+1);
            }else{
                $player_two_winrate = $player_two_total_wins/($player_two_total_matches+1);
            }

            $player_two_pvp_mode_details->update([
                'total_matches' => $player_two_pvp_mode_details->total_matches + 1,
                'winrate' => $data['draw'] ? $player_two_pvp_mode_details->winrate : round($player_two_winrate*100),
                'mmr' => $data['contestant_two']['updated_mmr']
            ]);

            DB::commit();
            return response()->json([
                'player_one' => $data['contestant_one'],
                'player_two' => $data['contestant_two'],
                'isDraw' => $data['draw']
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json($th, 409);
        }
    }

    public function computePlayerData(Request $request){
        $contestants = [];
        $draw = false;
        foreach ($request->match['contestants'] as $contestant) {
            array_push($contestants, $contestant);
        }
        $contestant_one = $contestants[0];
        $contestant_two = $contestants[1];

        $contestant_one['rating'] = round(1/(1+pow(10,($contestant_two['mmr']-$contestant_one['mmr'])/400)), 2);
        $contestant_two['rating'] = round(1/(1+pow(10,($contestant_one['mmr']-$contestant_two['mmr'])/400)), 2);

        $contestant_one['isWinner'] = $contestant_one['points'] > $contestant_two['points'] ? 1 : 0;
        $contestant_two['isWinner'] = $contestant_one['points'] < $contestant_two['points'] ? 1 : 0;

        $contestant_one['updated_mmr'] = round($contestant_one['mmr'] + 30*($contestant_one['isWinner']-$contestant_one['rating']));
        $contestant_two['updated_mmr'] = round($contestant_two['mmr'] + 30*($contestant_two['isWinner']-$contestant_two['rating']));

        if($contestant_one['points'] == $contestant_two['points']){
            $draw = true;
            $contestant_one['updated_mmr'] = $contestant_one['mmr'];
            $contestant_two['updated_mmr'] = $contestant_two['mmr'];
        }else{
            $contestant_one['updated_mmr'] = round($contestant_one['mmr'] + 30*($contestant_one['isWinner']-$contestant_one['rating']));
            $contestant_two['updated_mmr'] = round($contestant_two['mmr'] + 30*($contestant_two['isWinner']-$contestant_two['rating']));
        }

        return [
            'contestant_one' => $contestant_one,
            'contestant_two' => $contestant_two,
            'draw' => $draw
        ];
    }
}

