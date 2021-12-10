<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $AROfficerUserID = 3;
        $ARPresidentUserID = 4;
        $MemberUserID = 8;
        $data = [
                // AR Officer (2 role Officer + Member) Initial Permissions
                ['user_id' => 3, 'permission_id' => 1,],
                ['user_id' => 3, 'permission_id' => 2,],
                ['user_id' => 3, 'permission_id' => 3,],
                ['user_id' => 3, 'permission_id' => 4,],
                ['user_id' => 3, 'permission_id' => 5,],
                ['user_id' => 3, 'permission_id' => 6,],
                ['user_id' => 3, 'permission_id' => 7,],
                ['user_id' => 3, 'permission_id' => 8,],
                ['user_id' => 3, 'permission_id' => 9,],
                ['user_id' => 3, 'permission_id' => 10,],
                ['user_id' => 3, 'permission_id' => 11,],
                ['user_id' => 3, 'permission_id' => 12,],
                ['user_id' => 3, 'permission_id' => 13,],
                ['user_id' => 3, 'permission_id' => 14,],
                ['user_id' => 3, 'permission_id' => 16,],
                ['user_id' => 3, 'permission_id' => 17,],
                ['user_id' => 3, 'permission_id' => 18,],
                ['user_id' => 3, 'permission_id' => 19,],
                ['user_id' => 3, 'permission_id' => 20,],
                ['user_id' => 3, 'permission_id' => 21,],
                ['user_id' => 3, 'permission_id' => 22,],
                ['user_id' => 3, 'permission_id' => 23,],
                ['user_id' => 3, 'permission_id' => 24,],
                ['user_id' => 3, 'permission_id' => 25,],
                ['user_id' => 3, 'permission_id' => 26,],
                ['user_id' => 3, 'permission_id' => 27,],
                ['user_id' => 3, 'permission_id' => 29,],
                ['user_id' => 3, 'permission_id' => 28,],
                ['user_id' => 3, 'permission_id' => 30,],
                ['user_id' => 3, 'permission_id' => 31,],

                // AR President Initial Permissions
                ['user_id' => 4, 'permission_id' => 15,],
                ['user_id' => 4, 'permission_id' => 16,],
                ['user_id' => 4, 'permission_id' => 17,],
                ['user_id' => 4, 'permission_id' => 18,],
                ['user_id' => 4, 'permission_id' => 19,],
                ['user_id' => 4, 'permission_id' => 31,],

                // Member Initial Permissions
                ['user_id' => 8, 'permission_id' => 28,],
                ['user_id' => 8, 'permission_id' => 30,],
                ['user_id' => 8, 'permission_id' => 31,],

                // Super Admin Initial Permissions
                ['user_id' => 1, 'permission_id' => 32,],
                ['user_id' => 1, 'permission_id' => 33,],
                ['user_id' => 1, 'permission_id' => 34,],
                ['user_id' => 1, 'permission_id' => 35,],
                ['user_id' => 1, 'permission_id' => 36,],
                ['user_id' => 1, 'permission_id' => 37,],

                // AVP AR Officer (2 role Officer + Member) Initial Permissions
                ['user_id' => 9, 'permission_id' => 1,],
                ['user_id' => 9, 'permission_id' => 2,],
                ['user_id' => 9, 'permission_id' => 3,],
                ['user_id' => 9, 'permission_id' => 4,],
                ['user_id' => 9, 'permission_id' => 5,],
                ['user_id' => 9, 'permission_id' => 6,],
                ['user_id' => 9, 'permission_id' => 7,],
                ['user_id' => 9, 'permission_id' => 8,],
                ['user_id' => 9, 'permission_id' => 9,],
                ['user_id' => 9, 'permission_id' => 10,],
                ['user_id' => 9, 'permission_id' => 11,],
                ['user_id' => 9, 'permission_id' => 12,],
                ['user_id' => 9, 'permission_id' => 13,],
                ['user_id' => 9, 'permission_id' => 14,],
                ['user_id' => 9, 'permission_id' => 16,],
                ['user_id' => 9, 'permission_id' => 17,],
                ['user_id' => 9, 'permission_id' => 18,],
                ['user_id' => 9, 'permission_id' => 19,],
                ['user_id' => 9, 'permission_id' => 20,],
                ['user_id' => 9, 'permission_id' => 21,],
                ['user_id' => 9, 'permission_id' => 22,],
                ['user_id' => 9, 'permission_id' => 23,],
                ['user_id' => 9, 'permission_id' => 24,],
                ['user_id' => 9, 'permission_id' => 25,],
                ['user_id' => 9, 'permission_id' => 26,],
                ['user_id' => 9, 'permission_id' => 27,],
                ['user_id' => 9, 'permission_id' => 29,],
                ['user_id' => 9, 'permission_id' => 28,],
                ['user_id' => 9, 'permission_id' => 30,],
                ['user_id' => 9, 'permission_id' => 31,],
            
        ];
        DB::table('permission_user')->insert($data);
    }
}
