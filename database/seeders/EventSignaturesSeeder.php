<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSignaturesSeeder extends Seeder
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
                //Super admin
                'user_id' => '1',
                'role_id' => '1',
                'organization_id' => NULL,
                'signature_path' => NULL
            ],

           [
                //Adviser
                'user_id' => '10',
                'role_id' => '9',
                'organization_id' => 2,
                'signature_path' => NULL
            ],
            [
                //gpoa admin
                'user_id' => '6',
                'role_id' => '6',
                'organization_id' => 2,
                'signature_path' => NULL
            ],
            
            
        ];
        DB::table('event_signatures')->insert($data);
    }
}
