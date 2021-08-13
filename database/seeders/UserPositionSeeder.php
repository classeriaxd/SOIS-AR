<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['position_title_id' => '54',
             'user_id' => '1'
            ],
            ['position_title_id' => '6',
             'user_id' => '2'
            ],
            ['position_title_id' => '86',
             'user_id' => '3'
            ],
            ['position_title_id' => '70',
             'user_id' => '4'
            ],
            ['position_title_id' => '38',
             'user_id' => '5'
            ],
            ['position_title_id' => '118',
             'user_id' => '6'
            ],
            ['position_title_id' => '102',
             'user_id' => '7'
            ],
            ['position_title_id' => '103',
             'user_id' => '8'
            ],
            ['position_title_id' => '22',
             'user_id' => '9'
            ],
            ['position_title_id' => '119',
             'user_id' => '10'
            ],
            ['position_title_id' => '23',
             'user_id' => '11'
            ],


        ];
        DB::table('users_position_titles')->insert($data);
    }
}
