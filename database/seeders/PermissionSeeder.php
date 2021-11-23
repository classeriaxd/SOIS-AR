<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currentTime = Carbon::now()
        $data = [
            // format
        [
            'name' => 'HOMEPAGE-Add_Event', 'description' => 'Optional',
            'created_at' => $currentTime,
            'updated_at' => $currentTime,
        ],
            
        ];
        DB::table('permission')->insert($data);
    }
}
