<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function loginWithGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackFromGoogle()
    {
        try {
            DB::beginTransaction();
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', '=', $googleUser->email);

            if($user->exists()){
                $user = $user->get()->first();
            }else{

                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                    'is_welcome_tutorial_finished' => false,
                    'is_pvp_tutorial_finished' => false,
                    'is_google_account' => true,
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
                    'mmr' => 0
                ]);

            }
            DB::commit();
            Auth::loginUsingId($user->id, $remember = true);
            return redirect()->route('home');
        } catch (\Throwable $th) {
            return $th;
            DB::rollback();
            return back()->with('error', 'Something Went Wrong');
        }
    }
}
