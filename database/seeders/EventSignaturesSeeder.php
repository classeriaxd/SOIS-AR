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
                'user_id' => '16',
                'role_id' => '11',
                'organization_id' => NULL,
                'signature_path' => NULL
            ],

           [
                //Adviser
                'user_id' => '10',
                'role_id' => '9',
                'organization_id' => 3,
                'signature_path' => NULL
            ],
            [
                //gpoa admin
                'user_id' => '6',
                'role_id' => '6',
                'organization_id' => 3,
                'signature_path' => NULL
            ],
            [
                //Director
                'user_id' => '15',
                'role_id' => '10',
                'organization_id' => 3,
                'signature_path' => NULL
            ],
            
            
        ];
        DB::table('event_signatures')->insert($data);
    }
}
