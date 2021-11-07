<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventClassificationSeeder extends Seeder
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
            ['classification' => 'Intellectual', 
                'helper' => 'Events that relate to student development academically. (Ex. Quiz Bee, Seminars/Webinars, Tutorials)',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['classification' => 'Physical', 
                'helper' => 'Events that relate to  physical or mental competitive activities. (Ex. Basketball, Chess, Badminton)',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['classification' => 'Cultural', 
                'helper' => 'Events that relate to cultural and other art activities. (Ex. Dance, Speech Choir, Poster Making)',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['classification' => 'Spiritual', 
                'helper' => 'Events that relate to spiritual activities. (Ex. Monthly Mass)',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['classification' => 'Social', 
                'helper' => 'Events that relate to gatherings and social activities. (Ex. General Assembly, Team Building, Year-End Party)',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['classification' => 'Civic', 
                'helper' => 'Events that relate to community and service activities. (Ex. Flag Raising, Cleanup Drives, Outreach Programs)',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
        ];
        DB::table('event_classifications')->insert($data);
    }
}
