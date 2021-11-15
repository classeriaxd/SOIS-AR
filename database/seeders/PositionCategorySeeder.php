<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionCategorySeeder extends Seeder
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
                'position_category' => 'President',
            ],
            [
                // 2
                'position_category' => 'Affairs',
            ],
            [
                // 3
                'position_category' => 'Records',
            ],
            
            [
                // 4
                'position_category' => 'Documentation',
            ],

            [
                // 5
                'position_category' => 'Finance',
            ],

            [
                // 6
                'position_category' => 'Audit',
            ],

            [
                // 7
                'position_category' => 'Communications',
            ],
            
            [
                // 8
                'position_category' => 'Academics',
            ],
            [
                // 9
                'position_category' => 'Arts',
            ],
            [
                // 10
                'position_category' => 'Sports',
            ],
            [
                // 11
                'position_category' => 'Representative',
            ],

        ];
        DB::table('position_categories')->insert($data);
    }
}
