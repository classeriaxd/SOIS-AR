<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['category' => 'Academic',],
            ['category' => 'Non-academic',],
            ['category' => 'Cultural',],
            ['category' => 'Sports',],
        ];
        DB::table('event_categories')->insert($data);
    }
}
