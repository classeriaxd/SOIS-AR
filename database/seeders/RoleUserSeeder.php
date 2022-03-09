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
        $organization_id = 3; // CS
        $data = [
            [
                // Super Admin  
                'user_id' => 1,
                'role_id' => 1,
                'organization_id' => NULL,
            ],
            [  
                // Homepage 
                'user_id' => 2,
                'role_id' => 2,
                'organization_id' => $organization_id,
            ],
            [  
                // Ar Officer
                'user_id' => 3,
                'role_id' => 3,
                'organization_id' => $organization_id,
            ],
            [  
                // Ar Officer as member
                'user_id' => 3,
                'role_id' => 8,
                'organization_id' => $organization_id,
            ],
            [  // Ar presi
                'user_id' => 4,
                'role_id' => 4,
                'organization_id' => $organization_id,
            ],
            [  
                //membership
                'user_id' => 5,
                'role_id' => 5,
                'organization_id' => $organization_id,
            ],
            [  
                //membership - user role
                'user_id' => 5,
                'role_id' => 8,
                'organization_id' => $organization_id,
            ],
            [  
                // gpoa
                'user_id' => 6,
                'role_id' => 6,
                'organization_id' => $organization_id,
            ],
            [  
                // finance
                'user_id' => 7,
                'role_id' => 7,
                'organization_id' => $organization_id,
            ],
            [  
                // normal member/user
                'user_id' => 8,
                'role_id' => 8,
                'organization_id' => $organization_id,
            ],
            [  
                // AVP Ar Officer
                'user_id' => 9,
                'role_id' => 3,
                'organization_id' => $organization_id,
            ],
            [  
                // AVP Ar Officer as member
                'user_id' => 9,
                'role_id' => 8,
                'organization_id' => $organization_id,
            ],
            [  
                // Adviser
                'user_id' => 10,
                'role_id' => 9,
                'organization_id' => $organization_id,
            ],

            //Jones additional users
            [  
                // Membership BSA
                'user_id' => 11,
                'role_id' => 5,
                'organization_id' => 5,
            ],
            [  
                // GPOA BSA
                'user_id' => 12,
                'role_id' => 6,
                'organization_id' => 5,
            ],
            [  
                // Membership ERG
                'user_id' => 13,
                'role_id' => 5,
                'organization_id' => 12,
            ],
            [  
                // MEMBERSHIP PUPUKAW
                'user_id' => 14,
                'role_id' => 5,
                'organization_id' => 14,
            ],
            [  
                // Director
                'user_id' => 15,
                'role_id' => 10,
                'organization_id' => NULL,
            ],

            [  
                // Bernadeth Canlas
                // Head of Student Affairs Role
                'user_id' => 16,
                'role_id' => 11,
                'organization_id' => NULL,
            ],


            
        ];
        DB::table('role_user')->insert($data);
    }
}
