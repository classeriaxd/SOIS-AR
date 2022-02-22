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
                'asset_type_id' => 1,
                'type' => 'Logo',
                'asset_type_description' => 'This asset type is used for the logo of the page',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'asset_type_id' => 2,
                'type' => 'Banner',
                'asset_type_description' => 'This asset type is used for the logo of the page',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'asset_type_id' => 3,
                'type' => 'Carousel',
                'asset_type_description' => 'This asset type is used for the logo of the page',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'asset_type_id' => 4,
                'type' => 'Featured News Image',
                'asset_type_description' => 'This asset type is used for the logo of the page',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
        ];
        DB::table('asset_types')->insert($data);
    }
}
