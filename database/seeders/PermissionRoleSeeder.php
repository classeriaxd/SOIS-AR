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
        $data = [
            [
                // format
                'permission_id' => 1,
                'role_id' => 1,
            ],

            
        ];
        DB::table('permission_role')->insert($data);
    }
}
