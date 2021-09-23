<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['event_role' => 'Organizer',
                'helper' => 'The Event was organized by this Organization from planning to actual execution.',
            ],
            ['event_role' => 'Sponsor',
                'helper' => 'The Event was sponsored by this Organization by means of Financial Assistance or Manpower.',
            ],
            ['event_role' => 'Participant',
                'helper' => 'The Event was participated by the members of this Organization',
            ],
        ];
        DB::table('event_roles')->insert($data);
    }
}
