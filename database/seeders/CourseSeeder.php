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
            [
                'organization_id' => '5',
                'course_name' => 'Bachelor of Science in Accountancy',
                'course_acronym' => 'BSA', 
            ],
            [
                'organization_id' => '2',
                'course_name' => 'Bachelor of Science in Electronics and Communication Engineering',
                'course_acronym' => 'BSECE', 
            ],
            [
                'organization_id' => '7',
                'course_name' => 'Bachelor of Science Mechanical Engineering',
                'course_acronym' => 'BSME', 
            ],
            [
                'organization_id' => '6',
                'course_name' => 'Bachelor of Science in Business Administration Major in Human Resource Development Management',
                'course_acronym' => 'BSBA-HRDM', 
            ],
            [
                'organization_id' => '4',
                'course_name' => 'Bachelor of Science in Business Administration Major in Marketing Management',
                'course_acronym' => 'BSBA-MM', 
            ],
            [
                'organization_id' => '9',
                'course_name' => 'Bachelor of Science in Office Administration Major in Legal Transcription',
                'course_acronym' => 'BSOA-LT', 
            ],
            [
                'organization_id' => '8',
                'course_name' => 'Bachelor of Secondary Education Major in English',
                'course_acronym' => 'BSED-English', 
            ],
            [
                'organization_id' => '8',
                'course_name' => 'Bachelor of Secondary Education Major in Mathematics',
                'course_acronym' => 'BSED-Mathematics', 
            ],
            [
                'organization_id' => '3',
                'course_name' => 'Bachelor of Science in Information Technology',
                'course_acronym' => 'BSIT', 
            ],
            [
                'organization_id' => '9',
                'course_name' => 'Diploma in Office Management Technology with Specialization in Legal Office Management',
                'course_acronym' => 'DOMT-LOM', 
            ],
            [
                'organization_id' => '3',
                'course_name' => 'Diploma in Information Communication Technology',
                'course_acronym' => 'DICT', 
            ],
        ];
        DB::table('courses')->insert($data);
    }
}
