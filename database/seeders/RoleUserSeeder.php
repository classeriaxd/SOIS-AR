<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                // Super Admin  
                'user_id' => 1,
                'role_id' => 1,
            ],
            [  
                // Homepage 
                'user_id' => 2,
                'role_id' => 2,
            ],
            [  
                // Ar Officer
                'user_id' => 3,
                'role_id' => 3,
            ],
            [  // Ar presi
                'user_id' => 4,
                'role_id' => 4,
            ],
            [  
                //membership
                'user_id' => 5,
                'role_id' => 5,
            ],
            [  
                // gpoa
                'user_id' => 6,
                'role_id' => 6,
            ],
            [  
                // finance
                'user_id' => 7,
                'role_id' => 7,
            ],
            [  
                // normal member/user
                'user_id' => 8,
                'role_id' => 8,
            ],

            
        ];
        DB::table('role_user')->insert($data);
    }
}
