<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationTypeSeeder extends Seeder
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
                'organization_type' => 'Academic',
            ],
            
            [
                'organization_type' => 'Non-academic',
            ],
        ];
        DB::table('organization_types')->insert($data);
    }
}
