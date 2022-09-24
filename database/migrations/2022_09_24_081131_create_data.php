<?php

use App\Models\User;
use App\Models\Match;
use App\Models\Background;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            DB::beginTransaction();

            $user = User::get();
            $fakeUsers = $this->fakeUsers();

            Background::insert($this->fakeBackgrounds());

            foreach ($fakeUsers as $fakeUser) {
                $user = User::create($fakeUser['data']);

                $user->gamebackgrounds()->createMany($fakeUser['background']);

                $user->classicModeDetails()->create([
                    'current_level' => rand(0, 100),
                    'trophies' => rand(1, 250)
                ]);

                $user->pvpModeDetails()->create([
                    'total_matches' => rand(10, 100),
                    'winrate' => rand(10, 100),
                    'mmr' => rand(500, 1000)
                ]);

            }

            for ($i=1; $i <= 4; $i++) { 
                for ($j=0; $j < 10; $j++) { 
                    $this->generateMatches($i);
                }
            }

            DB::commit();
            return "yey!".$user->id;
        } catch (\Throwable $th) {
            DB::rollback();
            $this->down();
            throw $ex;
        }
    }

    public function generateMatches($id = 1)
    {
        $userIDs = [1, 2, 3, 4];
     
        $key = array_search($id, $userIDs, true);
        if ($key !== false) {
            array_splice($userIDs, $key, 1);
        }

        $match = Match::create();

        $match->participants()->createMany([
            [
                'user_id' => $id,
                'score' => rand(0, 100),
                'status' => true
            ],
            [
                'user_id' => $userIDs[rand(0, 2)],
                'score' => rand(0, 100),
                'status' => false
            ]
        ]);
    }

    public function fakeUsers()
    {
        $fakeUsers = [
            [
                'data' => [
                    'name' => 'Gem Cuevas',
                    'email' => 'gem.cuevas@gmail.com',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                    'is_welcome_tutorial_finished' => false,
                    'is_pvp_tutorial_finished' => false,
                    'in_game' => false
                ],
                'background' => [
                    [
                        'background_id' => 1,
                        'activated' => false
                    ],
                    [
                        'background_id' => rand(2, 4),
                        'activated' => true
                    ]
                ]
            ],
            [
                'data' => [
                    'name' => 'JJ Montilla',
                    'email' => 'jj.montilla@gmail.com',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                    'is_welcome_tutorial_finished' => false,
                    'is_pvp_tutorial_finished' => false,
                    'in_game' => false
                ],
                'background' => [
                    [
                        'background_id' => 1,
                        'activated' => false
                    ],
                    [
                        'background_id' => rand(2, 4),
                        'activated' => true
                    ]
                ]
            ],
            [
                'data' => [
                    'name' => 'John Patrick Buco',
                    'email' => 'patrick.buco@gmail.com',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                    'is_welcome_tutorial_finished' => false,
                    'is_pvp_tutorial_finished' => false,
                    'in_game' => false
                ],
                'background' => [
                    [
                        'background_id' => 1,
                        'activated' => false
                    ],
                    [
                        'background_id' => rand(2, 4),
                        'activated' => true
                    ]
                ]
            ],
            [
                'data' => [
                    'name' => 'Russell AronDela Rosa',
                    'email' => 'radelarosa@gmail.com',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                    'is_welcome_tutorial_finished' => false,
                    'is_pvp_tutorial_finished' => false,
                    'in_game' => false
                ],
                'background' => [
                    [
                        'background_id' => 1,
                        'activated' => false
                    ],
                    [
                        'background_id' => rand(2, 4),
                        'activated' => true
                    ]
                ]
            ]
        ];

        return $fakeUsers;
    }

    public function fakeBackgrounds()
    {
        return [
            [
                'name' => 'background-default.jpg',
                'photo' => 'background-default.jpg',
                'price' => 10
            ],
            [
                'name' => 'background-1.jpg',
                'photo' => 'background-1.jpg',
                'price' => 20
            ],
            [
                'name' => 'background-2.jpg',
                'photo' => 'background-2.jpg',
                'price' => 50
            ],
            [
                'name' => 'background-3.jpg',
                'photo' => 'background-3.jpg',
                'price' => 100
            ]
        ];
    }

    public function down()
    {
        return "GG";
    }

}
