<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TabularTableSeeder extends Seeder
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
            ['tabular_table_name' => 'VII. Students Awards/Recognitions from  Reputable Organizations',
                'reference_table_number' => 7,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['tabular_table_name' => 'VIII. Community Relation and Outreach Program',
                'reference_table_number' => 8,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['tabular_table_name' => 'IX. STUDENTS TRAININGS AND SEMINARS',
                'reference_table_number' => 9,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['tabular_table_name' => 'X. OTHER STUDENT ACTIVITIES',
                'reference_table_number' => 10,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            
        ];
        DB::table('tabular_tables')->insert($data);
    }
}
