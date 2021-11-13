<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationAssetSeeder extends Seeder
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
                'organization_id' => '1',
                'organization_asset_type_id' => 1,
                'file' => 'organization_assets/original/aeces.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'organization_id' => '2',
                'organization_asset_type_id' => 1,
                'file' => 'organization_assets/original/cs.png',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'organization_id' => '3',
                'organization_asset_type_id' => 1,
                'file' => 'organization_assets/original/jma.png',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'organization_id' => '4',
                'organization_asset_type_id' => 1,
                'file' => 'organization_assets/original/jpia.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'organization_id' => '5',
                'organization_asset_type_id' => 1,
                'file' => 'organization_assets/original/jpmap.png',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'organization_id' => '6',
                'organization_asset_type_id' => 1,
                'file' => 'organization_assets/original/jpsme.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
                        [
                'organization_id' => '7',
                'organization_asset_type_id' => 1,
                'file' => 'organization_assets/original/mentors.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'organization_id' => '8',
                'organization_asset_type_id' => 1,
                'file' => 'organization_assets/original/pasoa.png',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        DB::table('organization_assets')->insert($data);
    }
}
