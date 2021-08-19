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
            ['role' => 'Admin', 'description' => 'Admin'],
            ['role' => 'User', 'description' => 'Users/Students/Officers/Professors'],
        ];
        DB::table('roles')->insert($data);
    }
}
