<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class PageSeeder extends Seeder
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
                'is_default_home' => 1,
                'is_default_not_found' => NULL,
                'title' => 'Homepage',
                'slug' => 'homepage',
                'content' => NULL,
                'created_at' => '2021-10-23 23:20:44',
                'updated_at' => '2021-11-08 13:47:08',
                'primary_color' => '...',
                'secondary_color' => '...',
                'tertiary_color' => '...',
                'quarternary_color' => '...',
                'status' => '1',
                'is_announcements_activated' => 1,
                'is_events_activated' => 1,
                'is_articles_activated' => 1,
            ],
            [
                'is_default_home' => 1,
                'is_default_not_found' => NULL,
                'title' => 'error-404-page',
                'slug' => 'error-404-page',
                'content' => NULL,
                'created_at' => '2021-10-23 23:20:44',
                'updated_at' => '2021-11-08 13:47:08',
                'primary_color' => '...',
                'secondary_color' => '...',
                'tertiary_color' => '...',
                'quarternary_color' => '...',
                'status' => '2',
                'is_announcements_activated' => 1,
                'is_events_activated' => NULL,
                'is_articles_activated' => NULL,
            ],
            [
                'is_default_home' => 1,
                'is_default_not_found' => NULL,
                'title' => 'About',
                'slug' => 'about',
                'content' => NULL,
                'created_at' => '2021-10-23 23:20:44',
                'updated_at' => '2021-11-08 13:47:08',
                'primary_color' => '...',
                'secondary_color' => '...',
                'tertiary_color' => '...',
                'quarternary_color' => '...',
                'status' => '1',
                'is_announcements_activated' => 1,
                'is_events_activated' => NULL,
                'is_articles_activated' => NULL,
            ],


        ];
        DB::table('pages')->insert($data);
    }
}
