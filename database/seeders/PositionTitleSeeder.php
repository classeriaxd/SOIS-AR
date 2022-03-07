<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionTitleSeeder extends Seeder
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
                // 1
                'organization_id' => 3,
                'position_category_id' => 1,
                'position_title' => 'President',
            ],
            
            [
                // 2
                'organization_id' => 3,
                'position_category_id' => 2,
                'position_title' => 'Vice President for Internal Affairs',
            ],

            [
                // 3
                'organization_id' => 3,
                'position_category_id' => 2,
                'position_title' => 'Vice President for External Affairs',
            ],

            [
                // 4
                'organization_id' => 3,
                'position_category_id' => 3,
                'position_title' => 'Vice President for Records',
            ],

            [
                // 5
                'organization_id' => 3,
                'position_category_id' => 3,
                'position_title' => 'Assistant Vice President for Records',
            ],

            [
                // 6
                'organization_id' => 3,
                'position_category_id' => 4,
                'position_title' => 'Vice President for Research and Documentation',
            ],

            [
                // 7
                'organization_id' => 3,
                'position_category_id' => 4,
                'position_title' => 'Assistant Vice President for Research and Documentation ',
            ],

            [
                // 8
                'organization_id' => 3,
                'position_category_id' => 5,
                'position_title' => 'Vice President for Finance',
            ],

            [
                // 9
                'organization_id' => 3,
                'position_category_id' => 5,
                'position_title' => 'Assitant Vice President for Finance',
            ],

            [
                // 10
                'organization_id' => 3,
                'position_category_id' => 6,
                'position_title' => 'Vice President for Audit',
            ],

            [
                // 11
                'organization_id' => 3,
                'position_category_id' => 7,
                'position_title' => 'Vice President for Communications',
            ],

            [
                // 12
                'organization_id' => 3,
                'position_category_id' => 7,
                'position_title' => 'Assistant Vice President for Communications',
            ],

            [
                // 13
                'organization_id' => 3,
                'position_category_id' => 8,
                'position_title' => 'Vice President for Academics',
            ],

            [
                // 14
                'organization_id' => 3,
                'position_category_id' => 8,
                'position_title' => 'Assistant Vice President for Academics',
            ],

            [
                // 15
                'organization_id' => 3,
                'position_category_id' => 9,
                'position_title' => 'Vice President for Arts',
            ],

            [
                // 16
                'organization_id' => 3,
                'position_category_id' => 9,
                'position_title' => 'Assistant Vice President for Arts',
            ],

            [
                // 17
                'organization_id' => 3,
                'position_category_id' => 10,
                'position_title' => 'Vice Presient for Sports',
            ],

            [
                // 18
                'organization_id' => 3,
                'position_category_id' => 10,
                'position_title' => 'Assistant Vice Presient for Sports',
            ],

            [
                // 19
                'organization_id' => 3,
                'position_category_id' => 11,
                'position_title' => 'Computer Society Representative',
            ],
        ];
        DB::table('position_titles')->insert($data);
    }
}
