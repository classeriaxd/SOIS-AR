<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrganizationSeeder extends Seeder
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
            [
                'organization_type_id' => 1,
                'organization_name' => 'Association of Electronics Engineering Students',
                'organization_acronym' => 'AECES',
                'organization_details' => 'Organization Details',
                'organization_primary_color' => '#0376FF',
                'organization_secondary_color' => '#FFFFFF',
                'organization_slug' => 'aeces',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],

            [
                'organization_type_id' => 1,
                'organization_name' => 'Computer Society',
                'organization_acronym' => 'CS',
                'organization_details' => 'Organization Details',
                'organization_primary_color' => '#0376FF',
                'organization_secondary_color' => '#FFFFFF',
                'organization_slug' => 'cs',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],

            [
                'organization_type_id' => 1,
                'organization_name' => 'Junior Marketing Association',
                'organization_acronym' => 'JMA',
                'organization_details' => 'Organization Details',
                'organization_primary_color' => '#0376FF',
                'organization_secondary_color' => '#FFFFFF',
                'organization_slug' => 'jma',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],

            [
                'organization_type_id' => 1,
                'organization_name' => 'Junior Philippine Institutes of Accountants',
                'organization_acronym' => 'JPIA',
                'organization_details' => 'Organization Details',
                'organization_primary_color' => '#0376FF',
                'organization_secondary_color' => '#FFFFFF',
                'organization_slug' => 'jpia',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],

            [
                'organization_type_id' => 1,
                'organization_name' => 'Junior People Management Association of the Philippines',
                'organization_acronym' => 'JPMAP',
                'organization_details' => 'Organization Details',
                'organization_primary_color' => '#0376FF',
                'organization_secondary_color' => '#FFFFFF',
                'organization_slug' => 'jpmap',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],

            [
                'organization_type_id' => 1,
                'organization_name' => 'Junior Philippine Society of Mechanical Engineering',
                'organization_acronym' => 'JPSME',
                'organization_details' => 'Organization Details',
                'organization_primary_color' => '#0376FF',
                'organization_secondary_color' => '#FFFFFF',
                'organization_slug' => 'jpsme',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],

            [
                'organization_type_id' => 1,
                'organization_name' => 'Mentor\'s Society',
                'organization_acronym' => 'MS',
                'organization_details' => 'Organization Details',
                'organization_primary_color' => '#0376FF',
                'organization_secondary_color' => '#FFFFFF',
                'organization_slug' => 'ms',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],

            [
                'organization_type_id' => 1,
                'organization_name' => 'Philippine Association of Students in Office Administration',
                'organization_acronym' => 'PASOA',
                'organization_details' => 'Organization Details',
                'organization_primary_color' => '#0376FF',
                'organization_secondary_color' => '#FFFFFF',
                'organization_slug' => 'pasoa',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
        ];
        DB::table('organizations')->insert($data);
    }
}
