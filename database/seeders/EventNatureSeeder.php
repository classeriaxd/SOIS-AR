<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventNatureSeeder extends Seeder
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
            ['nature' => 'Skills/Technical', 
                'helper' => 'The event focuses on improving the skills and knowledge of the student',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['nature' => 'Inclusivity/Diversity', 
                'helper' => 'The event focuses on creating an environment for the students to feel an essential part of it',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['nature' => 'Professional', 
                'helper' => 'The event focuses on professional growth and development of the student',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['nature' => 'GAD Related', 
                'helper' => 'The event focuses on gender and development',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
        ];
        DB::table('event_natures')->insert($data);
    }
}
