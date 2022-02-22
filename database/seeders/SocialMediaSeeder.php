<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SocialMediaSeeder extends Seeder
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
                'social_media_id' => 1,
                'social_media_name' => 'Facebook',
                'status' => '1',
                'embed_logo' => '...',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'social_media_id' => 2,
                'social_media_name' => 'Twitter',
                'status' => '1',
                'embed_logo' => '...',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'social_media_id' => 3,
                'social_media_name' => 'Instagram',
                'status' => '1',
                'embed_logo' => '...',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
        ];
        DB::table('social_media')->insert($data);
    }
}
