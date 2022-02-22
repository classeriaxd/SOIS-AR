<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ArticleTypeSeeder extends Seeder
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
                'article_type' => 'School News',
                'status' => '1',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'article_type' => 'Event News',
                'status' => '1',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
        ];
        DB::table('article_types')->insert($data);
    }
}
