<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $AROfficerRoleID = 3;
        $ARPresidentOfficerRoleID = 4;
        $MemberRoleID = 8;
        $data = [
                // AR Officer Permissions
                ['role_id' => 3, 'permission_id' => 1,],
                ['role_id' => 3, 'permission_id' => 2,],
                ['role_id' => 3, 'permission_id' => 3,],
                ['role_id' => 3, 'permission_id' => 4,],
                ['role_id' => 3, 'permission_id' => 5,],
                ['role_id' => 3, 'permission_id' => 6,],
                ['role_id' => 3, 'permission_id' => 7,],
                ['role_id' => 3, 'permission_id' => 8,],
                ['role_id' => 3, 'permission_id' => 9,],
                ['role_id' => 3, 'permission_id' => 10,],
                ['role_id' => 3, 'permission_id' => 11,],
                ['role_id' => 3, 'permission_id' => 12,],
                ['role_id' => 3, 'permission_id' => 13,],
                ['role_id' => 3, 'permission_id' => 14,],
                ['role_id' => 3, 'permission_id' => 16,],
                ['role_id' => 3, 'permission_id' => 17,],
                ['role_id' => 3, 'permission_id' => 18,],
                ['role_id' => 3, 'permission_id' => 19,],
                ['role_id' => 3, 'permission_id' => 20,],
                ['role_id' => 3, 'permission_id' => 21,],
                ['role_id' => 3, 'permission_id' => 22,],
                ['role_id' => 3, 'permission_id' => 23,],
                ['role_id' => 3, 'permission_id' => 24,],
                ['role_id' => 3, 'permission_id' => 25,],
                ['role_id' => 3, 'permission_id' => 26,],
                ['role_id' => 3, 'permission_id' => 27,],
                ['role_id' => 3, 'permission_id' => 29,],
                ['role_id' => 3, 'permission_id' => 38,],

                // AR President Permissions
                ['role_id' => 4, 'permission_id' => 15,],
                ['role_id' => 4, 'permission_id' => 16,],
                ['role_id' => 4, 'permission_id' => 17,],
                ['role_id' => 4, 'permission_id' => 18,],
                ['role_id' => 4, 'permission_id' => 19,],
                ['role_id' => 4, 'permission_id' => 31,],

                // Member Permissions
                ['role_id' => 8, 'permission_id' => 28,],
                ['role_id' => 8, 'permission_id' => 30,],
                ['role_id' => 8, 'permission_id' => 31,],
                ['role_id' => 8, 'permission_id' => 18,],
                ['role_id' => 8, 'permission_id' => 19,],

                // Super Admin Permissions
                ['role_id' => 1, 'permission_id' => 32,],
                ['role_id' => 1, 'permission_id' => 33,],
                ['role_id' => 1, 'permission_id' => 34,],
                ['role_id' => 1, 'permission_id' => 35,],
                ['role_id' => 1, 'permission_id' => 36,],
                ['role_id' => 1, 'permission_id' => 37,],

                // Head of Student Services Permission
                ['role_id' => 1, 'permission_id' => 32,],
                ['role_id' => 1, 'permission_id' => 33,],
                ['role_id' => 1, 'permission_id' => 34,],
                ['role_id' => 1, 'permission_id' => 35,],
                ['role_id' => 1, 'permission_id' => 36,],

                // Director Permission
                ['role_id' => 1, 'permission_id' => 32,],
                ['role_id' => 1, 'permission_id' => 33,],
                ['role_id' => 1, 'permission_id' => 34,],
                ['role_id' => 1, 'permission_id' => 35,],
                ['role_id' => 1, 'permission_id' => 36,],
        ];
        DB::table('permission_role')->insert($data);
    }
}
