<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['role' => 'Super Admin', 'description' => 'Main Admin'],
            ['role' => 'Admin', 'description' => 'Admin/Officers/Professors'],
            ['role' => 'User', 'description' => 'Users/Students'],
            ['role' => 'viewer', 'description' => 'Viewers/Outsiders']
        ];
        DB::table('roles')->insert($data);
    }
}
