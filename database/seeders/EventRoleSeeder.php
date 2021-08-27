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
            ['event_role' => 'Organizer',],
            ['event_role' => 'Sponsor',],
            ['event_role' => 'Participant',],
        ];
        DB::table('event_roles')->insert($data);
    }
}
