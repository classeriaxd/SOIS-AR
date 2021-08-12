<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
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
                'organization_name' => 'Association of Electronics Engineering Students',
                'organization_acronym' => 'AECES',
            ],

            [
                'organization_name' => 'Computer Society',
                'organization_acronym' => 'CS',
            ],

            [
                'organization_name' => 'Junior Marketing Association',
                'organization_acronym' => 'JMA',
            ],

            [
                'organization_name' => 'Junior Philippine Institutes of Accountants',
                'organization_acronym' => 'JPIA',
            ],

            [
                'organization_name' => 'Junior People Management Association of the Philippines',
                'organization_acronym' => 'JPMAP',
            ],

            [
                'organization_name' => 'Junior Philippine Society of Mechanical Engineering',
                'organization_acronym' => 'JPSME',
            ],

            [
                'organization_name' => 'Mentor\'s Society',
                'organization_acronym' => 'MS',
            ],

            [
                'organization_name' => 'Philippine Association of Students in Office Administration',
                'organization_acronym' => 'PASOA',
            ],
        ];
        DB::table('organizations')->insert($data);
    }
}
