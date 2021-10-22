<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventRoleSeeder extends Seeder
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
            ['event_role' => 'Organizer',
                'helper' => 'The Event was organized by this Organization from planning to actual execution.',
                'background_color' => '#0376FF',
                'text_color' => '#FFFFFF',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['event_role' => 'Sponsor',
                'helper' => 'The Event was sponsored by this Organization by means of Financial Assistance or Manpower.',
                'background_color' => '#168854',
                'text_color' => '#FFFFFF',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            ['event_role' => 'Participant',
                'helper' => 'The Event was participated by the members of this Organization',
                'background_color' => '#6F737E',
                'text_color' => '#000000',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
        ];
        DB::table('event_roles')->insert($data);
    }
}
