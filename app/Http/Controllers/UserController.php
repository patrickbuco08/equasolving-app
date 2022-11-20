<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Match;
use App\Models\Background;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function manualLogin(User $user)
    {
        Auth::loginUsingId($user->id, $remember = true);
        return redirect()->route('home');
    }

    public function checkIfAuthenticated()
    {
      $status_code = 401;
      $user = null;

      if(Auth::check()){
        $status_code = 200;
        $user = auth()->user()->load('pvpModeDetails');
      }

      return response()->json($user, $status_code);
      
    }

    public function createUsingNickName(Request $request)
    {
        sleep(1);
        try {
            DB::beginTransaction();

            $faker = Faker::create();
            $fakeEmail = $faker->unique()->safeEmail();

            $user = User::create([
                'name' => $request->nickname,
                'email' => $fakeEmail,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                'is_welcome_tutorial_finished' => false,
                'is_pvp_tutorial_finished' => false,
                'is_google_account' => false,
                'in_game' => false,
                'room_id' => null
            ]);

            $user->ownedBackgrounds()->create([
                'background_id' => 1,
                'activated' => true
            ]);

            $user->classicModeDetails()->create([
                'current_level' => 0,
                'trophies' => 0
            ]);

            $user->pvpModeDetails()->create([
                'total_matches' => 0,
                'winrate' => 0,
                'mmr' => 500
            ]);

            DB::commit();
            Auth::loginUsingId($user->id, $remember = true);
            return response()->json($user, 201);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json($th, 409);
        }
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

    public function equipTheme(Request $request)
    {

        try {
            DB::beginTransaction();

            auth()->user()->ownedBackgrounds()->update([
                'activated' => 0
            ]);
    
            auth()->user()->ownedBackgrounds->where('background_id', $request->id)->first()->update([
                'activated' => true
            ]);
            DB::commit();
            return response()->json("success", 204);
        } catch (\Throwable $th) {
            return response()->json($th, 409);
        }

    }

    public function purchaseTheme(Request $request)
    {
        // return $request->id;

        $user = auth()->user();
        $selectedBackground = Background::where('id', $request->id)->first();
        $current_trophies = $user->classicModeDetails->trophies;

        

        try {
            DB::beginTransaction();

            if($selectedBackground->price > $current_trophies){
                throw new Exception("not enough trophies", 1);
            }

            $user->ownedBackgrounds()->update([
                'activated' => 0
            ]);

            $user->classicModeDetails()->update([
                'trophies' => $current_trophies - $selectedBackground->price
            ]);

            $userBgExist = $user->ownedBackgrounds->where('background_id', $request->id)->first();

            if($userBgExist){
                $userBgExist->update([
                    'activated' => 1
                ]);
            }else{
                $user->ownedBackgrounds()->create([
                    'background_id' => $request->id,
                    'activated' => true
                ]);
            }

            DB::commit();
            return response()->json("success", 201);
        } catch (\Throwable $th) {
            return response()->json($th, 403);
        }
    }


}
