<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class PageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currentTime = Carbon::now();
        $data = [
            [
                'page_types_id' => 1,
                'page_type' => 'system page',
                'page_description' => 'This page type is used for the system pages the syttem is using',
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'page_types_id' => 2,
                'page_type' => 'news',
                'page_description' => 'This page type is used for the news page',
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'page_types_id' => 3,
                'page_type' => 'announcements',
                'page_description' => 'This page type is used for the announcements page',
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'page_types_id' => 4,
                'page_type' => 'organizations',
                'page_description' => 'This page type is used for the organizations page',
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'page_types_id' => 5,
                'page_type' => 'default interfaces',
                'page_description' => 'This page type is used for the default interfaces page',
                'status' => 1,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
        ];
        DB::table('page_types')->insert($data);
    }
}
