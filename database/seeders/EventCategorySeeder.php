<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventCategorySeeder extends Seeder
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
            ['category' => 'Academic', 
                'helper' => 'Events that relates to competitive Academic Activities and Academic Awards. (Ex. Quiz Bees, Debates, Recognitions)',
                'background_color' => '#0376FF',
                'text_color' => '#FFFFFF',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],

            ['category' => 'Non-academic', 
                'helper' => 'Events that relates to Social, Civic, or Spiritual Improvement and Obligations. (Ex. Monthly Mass, Flag Raising Ceremony, Elections)',
                'background_color' => '#D43A42',
                'text_color' => '#FFFFFF',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['category' => 'Cultural', 
                'helper' => 'Events that relates to Cultural and Social Improvement. (Ex. Cultural Dances, Speech Choirs, Poster Making)',
                'background_color' => '#FFBB1B',
                'text_color' => '#000000',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['category' => 'Sports', 
                'helper' => 'Events that relates to competitive Physical or Mental Activities. (Ex. Basketball, Chess, Badminton)',
                'background_color' => '#168854',
                'text_color' => '#FFFFFF',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['category' => 'Seminars/Workshops', 
                'helper' => 'Events that relates Education and Academic Improvements. (Ex. Seminars, Workshops, Webinars, Tutorials)',
                'background_color' => '#3FB1BB',
                'text_color' => '#FFFFFF',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['category' => 'Community Outreach', 
                'helper' => 'Events that relate to helping and educating communities outside the University. (Ex. Cleanup Drives, Relief Operations, Public Lectures)',
                'background_color' => '#3FB1BB',
                'text_color' => '#FFFFFF',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
        ];
        DB::table('event_categories')->insert($data);
    }
}
