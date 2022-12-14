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

                $user->ownedBackgrounds()->createMany($fakeUser['background']);

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
        } catch (\Throwable $ex) {
            DB::rollback();
            $this->down();
            throw $ex;
        }
    }

    public function generateMatches($id = 1)
    {
        $userCollection = collect([1, 2, 3, 4]);
     
        $filtered = $userCollection->reject(function ($value, $key) use($id) {
            return $value == $id;
        });

        $match = Match::create([
            'unique_id' => uniqid()
        ]);
        $match->participants()->createMany([
            [
                'user_id' => $id,
                'score' => rand(0, 100),
                'status' => true
            ],
            [
                'user_id' => collect($filtered->all())->random(),
                'score' => rand(0, 100),
                'status' => false
            ]
        ]);
    }

    public function fakeUsers()
    {
        $additionalInformation = [
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
            'is_welcome_tutorial_finished' => false,
            'is_pvp_tutorial_finished' => false,
            'is_google_account' => true,
            'in_game' => false,
            'room_id' => 0
        ];

        $defaultBackgound = [
            'background_id' => 1,
            'activated' => false,
        ];

        $fakeUsers = [
            [
                'data' => [
                    'name' => 'Gem Cuevas',
                    'email' => 'gem.cuevas@gmail.com',
                ],
                'background' => [
                    $defaultBackgound,
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
                ],
                'background' => [
                    $defaultBackgound,
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
                ],
                'background' => [
                    $defaultBackgound,
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
                ],
                'background' => [
                    $defaultBackgound,
                    [
                        'background_id' => rand(2, 4),
                        'activated' => true
                    ]
                ]
            ]
        ];

        $users = [];

        foreach ($fakeUsers as $fakeUser) {
            $fakeUser['data'] = array_merge($fakeUser['data'], $additionalInformation);
            array_push($users, $fakeUser);
        }

        return $users;
    }

    public function fakeBackgrounds()
    {
        return [
            [
                'name' => 'Default',
                'css_theme' => 'main-default',
                'theme_id' => 'default-theme',
                'price' => 10
            ],
            [
                'name' => 'Clouds',
                'css_theme' => 'main-cloud',
                'theme_id' => 'cloud-theme',
                'price' => 20
            ],
            [
                'name' => 'Sun and Moon',
                'css_theme' => 'main-sun',
                'theme_id' => 'sun-theme',
                'price' => 50
            ],
            [
                'name' => 'Night Shade',
                'css_theme' => 'main-mid',
                'theme_id' => 'night-theme',
                'price' => 100
            ]
        ];
    }

    public function down()
    {
        return "GG";
    }

}
