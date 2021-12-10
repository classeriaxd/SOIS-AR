<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // 1
            [
                'organization_id' => '4',
                'course_name' => 'Bachelor of Science in Accountancy',
                'course_acronym' => 'BSA', 
            ],
            // 2
            [
                'organization_id' => '1',
                'course_name' => 'Bachelor of Science in Electronics and Communication Engineering',
                'course_acronym' => 'BSECE', 
            ],
            // 3
            [
                'organization_id' => '6',
                'course_name' => 'Bachelor of Science Mechanical Engineering',
                'course_acronym' => 'BSME', 
            ],
            // 4
            [
                'organization_id' => '5',
                'course_name' => 'Bachelor of Science in Business Administration Major in Human Resource Development Management',
                'course_acronym' => 'BSBA-HRDM', 
            ],
            // 5
            [
                'organization_id' => '3',
                'course_name' => 'Bachelor of Science in Business Administration Major in Marketing Management',
                'course_acronym' => 'BSBA-MM', 
            ],
            // 6
            [
                'organization_id' => '8',
                'course_name' => 'Bachelor of Science in Office Administration Major in Legal Transcription',
                'course_acronym' => 'BSOA-LT', 
            ],
            // 7
            [
                'organization_id' => '7',
                'course_name' => 'Bachelor of Secondary Education Major in English',
                'course_acronym' => 'BSED-English', 
            ],
            // 8
            [
                'organization_id' => '7',
                'course_name' => 'Bachelor of Secondary Education Major in Mathematics',
                'course_acronym' => 'BSED-Mathematics', 
            ],
            // 9
            [
                'organization_id' => '2',
                'course_name' => 'Bachelor of Science in Information Technology',
                'course_acronym' => 'BSIT', 
            ],
            // 10
            [
                'organization_id' => '8',
                'course_name' => 'Diploma in Office Management Technology with Specialization in Legal Office Management',
                'course_acronym' => 'DOMT-LOM', 
            ],
            // 11
            [
                'organization_id' => '2',
                'course_name' => 'Diploma in Information Communication Technology',
                'course_acronym' => 'DICT', 
            ],
        ];
        DB::table('courses')->insert($data);
    }
}
