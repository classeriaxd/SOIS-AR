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
                'image' => 'organizational_assets/aeces.jpg',
                'type' => '1',
            ],
            [
                'organization_id' => '2',
                'image' => 'organizational_assets/cs.png',
                'type' => '1',
            ],
            [
                'organization_id' => '3',
                'image' => 'organizational_assets/jma.png',
                'type' => '1',
            ],
            [
                'organization_id' => '4',
                'image' => 'organizational_assets/jpia.jpg',
                'type' => '1',
            ],
            [
                'organization_id' => '5',
                'image' => 'organizational_assets/jpmap.png',
                'type' => '1',
            ],
            [
                'organization_id' => '6',
                'image' => 'organizational_assets/jpsme.jpg',
                'type' => '1',
            ],
                        [
                'organization_id' => '7',
                'image' => 'organizational_assets/mentors.jpg',
                'type' => '1',
            ],
            [
                'organization_id' => '8',
                'image' => 'organizational_assets/pasoa.png',
                'type' => '1',
            ],
        ];
        DB::table('roles')->insert($data);
    }
}
