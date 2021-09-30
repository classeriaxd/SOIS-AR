<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['category' => 'Academic', 
                'helper' => 'Events that relates to Education and Academic Improvement. Ex. (Quiz Bees, Seminar/Webinars, Tutorials)'
            ],

            ['category' => 'Non-academic', 
                'helper' => 'Events that relates to Social, Civic, or Spiritual Improvement and Obligations. (Ex. Monthly Mass, Flag Raising Ceremony, Elections)'
            ],
            ['category' => 'Cultural', 
                'helper' => 'Events that relate to Cultural and Social Improvement. (Ex. Cultural Dances, Speech Choirs, Poster Making)'
            ],
            ['category' => 'Sports', 
                'helper' => 'Events that relate to competitive Physical or Mental Activities. (Ex. Basketball, Chess, Badminton)'
            ],
            ['category' => 'Community Outreach', 
                'helper' => 'Events that relate to helping and educating communities outside the University. (Ex. Cleanup Drives, Relief Operations, Public Lectures)'
            ],
        ];
        DB::table('event_categories')->insert($data);
    }
}
