<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseOrganizationSeeder extends Seeder
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
                'organization_id' => '1',
                'course_id' => '2',
            ],
            [
                'organization_id' => '2',
                'course_id' => '9',
            ],
            [
                'organization_id' => '2',
                'course_id' => '11',
            ],
            [
                'organization_id' => '3',
                'course_id' => '5',
            ],
            [
                'organization_id' => '4',
                'course_id' => '1',
            ],
            [
                'organization_id' => '5',
                'course_id' => '4',
            ],
            [
                'organization_id' => '6',
                'course_id' => '3',
            ],
            [
                'organization_id' => '7',
                'course_id' => '7',
            ],
            [
                'organization_id' => '7',
                'course_id' => '8',
            ],
            [
                'organization_id' => '8',
                'course_id' => '6',
            ],
            [
                'organization_id' => '8',
                'course_id' => '10',
            ],
        ];
        DB::table('course_organization')->insert($data);
    }
}
