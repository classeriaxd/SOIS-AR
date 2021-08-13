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
                'image' => 'organization_assets/aeces.jpg',
                'type' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'organization_id' => '2',
                'image' => 'organization_assets/cs.png',
                'type' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'organization_id' => '3',
                'image' => 'organization_assets/jma.png',
                'type' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'organization_id' => '4',
                'image' => 'organization_assets/jpia.jpg',
                'type' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'organization_id' => '5',
                'image' => 'organization_assets/jpmap.png',
                'type' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'organization_id' => '6',
                'image' => 'organization_assets/jpsme.jpg',
                'type' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
                        [
                'organization_id' => '7',
                'image' => 'organization_assets/mentors.jpg',
                'type' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'organization_id' => '8',
                'image' => 'organization_assets/pasoa.png',
                'type' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        DB::table('organization_assets')->insert($data);
    }
}
