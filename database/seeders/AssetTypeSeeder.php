<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AssetTypeSeeder extends Seeder
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
                'type' => 'Logo',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'type' => 'Carousel',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'type' => 'Featured News Image',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'type' => 'Banner',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
        ];
        DB::table('asset_types')->insert($data);
    }
}
