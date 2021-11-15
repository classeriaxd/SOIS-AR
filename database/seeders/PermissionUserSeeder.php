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
        $data = [
            [
                // format
                'permission_id' => 1,
                'user_id' => 1,
            ],

            
        ];
        DB::table('permission_user')->insert($data);
    }
}
