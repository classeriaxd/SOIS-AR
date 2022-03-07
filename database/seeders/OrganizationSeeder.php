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
             // count=1 originalValue=placeholder
            [
                'organization_type_id' => 1,
                'organization_name' => 'Polytechnic University of the Philippines',
                'organization_acronym' => 'PUP',
                'organization_details' => '...',
                'organization_primary_color' => '...',
                'organization_secondary_color' => '...',
                'organization_tertiary_color' => '...',
                'organization_slug' => '/',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => 1,
            ],
            // count=2 originalValue=1
            [
                'organization_type_id' => 1,
                'organization_name' => 'Association of Electronics Engineering Students',
                'organization_acronym' => 'AECES',
                'organization_details' => 'Organization Details',
                'organization_primary_color' => '#0376FF',
                'organization_secondary_color' => '#FFFFFF',
                'organization_tertiary_color' => '#1bbede',
                'organization_slug' => 'aeces',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => 1,
            ],
            // count=3 originalValue=2
            [
                'organization_type_id' => 1,
                'organization_name' => 'Computer Society',
                'organization_acronym' => 'CS',
                'organization_details' => 'Organization Details',
                'organization_primary_color' => '#0376FF',
                'organization_secondary_color' => '#FFFFFF',
                'organization_tertiary_color' => '#1bbede',
                'organization_slug' => 'cs',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => 1,
            ],
            // count=4 originalValue=3
            [
                'organization_type_id' => 1,
                'organization_name' => 'Junior Marketing Association',
                'organization_acronym' => 'JMA',
                'organization_details' => 'Organization Details',
                'organization_primary_color' => '#0376FF',
                'organization_secondary_color' => '#FFFFFF',
                'organization_tertiary_color' => '#1bbede',
                'organization_slug' => 'jma',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => 1,
            ],
            // count=5 originalValue=4
            [
                'organization_type_id' => 1,
                'organization_name' => 'Junior Philippine Institutes of Accountants',
                'organization_acronym' => 'JPIA',
                'organization_details' => 'Organization Details',
                'organization_primary_color' => '#0376FF',
                'organization_secondary_color' => '#FFFFFF',
                'organization_tertiary_color' => '#1bbede',
                'organization_slug' => 'jpia',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => 1,
            ],
            // count=6 originalValue=5
            [
                'organization_type_id' => 1,
                'organization_name' => 'Junior People Management Association of the Philippines',
                'organization_acronym' => 'JPMAP',
                'organization_details' => 'Organization Details',
                'organization_primary_color' => '#0376FF',
                'organization_secondary_color' => '#FFFFFF',
                'organization_tertiary_color' => '#1bbede',
                'organization_slug' => 'jpmap',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => 1,
            ],
            // count=7 originalValue=6
            [
                'organization_type_id' => 1,
                'organization_name' => 'Junior Philippine Society of Mechanical Engineering',
                'organization_acronym' => 'JPSME',
                'organization_details' => 'Organization Details',
                'organization_primary_color' => '#0376FF',
                'organization_secondary_color' => '#FFFFFF',
                'organization_tertiary_color' => '#1bbede',
                'organization_slug' => 'jpsme',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => 1,
            ],
            // count=8 originalValue=7
            [
                'organization_type_id' => 1,
                'organization_name' => 'Mentor\'s Society',
                'organization_acronym' => 'MS',
                'organization_details' => 'Organization Details',
                'organization_primary_color' => '#0376FF',
                'organization_secondary_color' => '#FFFFFF',
                'organization_tertiary_color' => '#1bbede',
                'organization_slug' => 'ms',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => 1,
            ],
            // count=9 originalValue=8
            [
                'organization_type_id' => 1,
                'organization_name' => 'Philippine Association of Students in Office Administration',
                'organization_acronym' => 'PASOA',
                'organization_details' => 'Organization Details',
                'organization_primary_color' => '#0376FF',
                'organization_secondary_color' => '#FFFFFF',
                'organization_tertiary_color' => '#1bbede',
                'organization_slug' => 'pasoa',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => 1,
            ],
            // count=10 originalValue=9
            [
                'organization_type_id' => '2',
                'organization_name' => 'Central Student Council',
                'organization_acronym' => 'CSC',
                'organization_details' => 'Organization Details',
                'organization_primary_color' => '#0376FF',
                'organization_secondary_color' => '#FFFFFF',
                'organization_tertiary_color' => '#1bbede',
                'organization_slug' => 'CSC',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => 1,
            ],
            // count=11 originalValue=10
            [
                'organization_type_id' => '2',
                'organization_name' => 'Radio Engineering Circle',
                'organization_acronym' => 'REC',
                'organization_details' => 'Organization Details',
                'organization_primary_color' => '#0376FF',
                'organization_secondary_color' => '#FFFFFF',
                'organization_tertiary_color' => '#1bbede',
                'organization_slug' => 'REC',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => 1,
            ],
            // count=12 originalValue=11
            [
                'organization_type_id' => '2',
                'organization_name' => 'Emergency Response Group',
                'organization_acronym' => 'ERG',
                'organization_details' => 'Organization Details',
                'organization_primary_color' => '#0376FF',
                'organization_secondary_color' => '#FFFFFF',
                'organization_tertiary_color' => '#1bbede',
                'organization_slug' => 'ERG',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => 1,
            ],
            // count=13 originalValue=12
            [
                'organization_type_id' => '2',
                'organization_name' => 'iRock Campus',
                'organization_acronym' => 'IC',
                'organization_details' => 'Organization Details',
                'organization_primary_color' => '#0376FF',
                'organization_secondary_color' => '#FFFFFF',
                'organization_tertiary_color' => '#1bbede',
                'organization_slug' => 'irock-campus',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => 1,
            ],
            // count=14 originalValue=13 
            [
                'organization_type_id' => '2',
                'organization_name' => 'Pupukaw',
                'organization_acronym' => 'Pupukaw',
                'organization_details' => 'Organization Details',
                'organization_primary_color' => '#0376FF',
                'organization_secondary_color' => '#FFFFFF',
                'organization_tertiary_color' => '#1bbede',
                'organization_slug' => 'pupukaw',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => 1,
            ],
            // count=15 originalValue=14
            [
                'organization_type_id' => 2,
                'organization_name' => 'The Chronicler',
                'organization_acronym' => 'The Chronicler',
                'organization_details' => '...',
                'organization_primary_color' => '#1bbede',
                'organization_secondary_color' => '#1bbede',
                'organization_tertiary_color' => '#1bbede',
                'organization_slug' => 'the-chronicler',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => 1,
            ]
        ];
        DB::table('organizations')->insert($data);
    }
}
