<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PvpController extends Controller
{
    public function setMatch(Request $request)
    {
        sleep(1);
        return $request->all();
    }

    public function saveMatch(Request $request)
    {
        $roomID = $request->room_id;
        $contestants = [];

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

        return [
            'contestant_one' => $contestant_one,
            'contestant_two' => $contestant_two
        ];

        // return $request->match['contestants'][0];


    }
}

// MMR based, Starting MMR is 500. The match queue is random but the MMR points that will be added or deducted will be computed using Elo Rating Algorithm.

//    >Firstly, both players’ rating in competitive mode will be computed using the formula (Rating for Player 1) R1=1/(1+〖10〗^((r2-r1)/400) )  and (Rating for Player 2) R2=1/(1+〖10〗^((r1-r2)/400) )  and this will be the expected score. In most of the games, “Actual Score” is either 0 or 1 means player either wins or loose. The developers decided that the constant value is K=30. The updated MMR will be computed as (Updated MMR for Player 1) U1=P1 current MMR + Constant (Actual Score – R1) and (Updated MMR for Player 2) U2=P2 current MMR + Constant (Actual Score – R2)
// Example: Player1=500 MMR and Player2=400MMR
// R1=1/(1+〖10〗^((r2-r1)/400) ) =1/(1+〖10〗^((400-500)/400) )=0.64
// R2=1/(1+〖10〗^((r1-r2)/400) ) =1/(1+〖10〗^((500-400)/400) )=0.36
// The developers decided that the constant value is K=30.
// If Player 1 wins, P1 actual score is 1 and P2 actual score is 0
// U1=P1 current MMR + Constant (Actual Score – R1)
// U1=500 + 30 (1 – 0.64) =510.8 =511
// U2=400 + 30 (0 – 0.36) =389.2 =389
// If Player 2 wins, P1 actual score is 0 and P2 actual score is 1
// U1=500 + 30 (0 – 0.64) =480.8 =481
// U2=400 + 30 (1 – 0.36) =419.2 =419
