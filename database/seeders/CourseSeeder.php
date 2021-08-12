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
                'course_name' => 'Bachelor of Science in Accountancy',
                'course_acronym' => 'BSA', 
            ],
            [
                'course_name' => 'Bachelor of Science in Electronics and Communication Engineering',
                'course_acronym' => 'BSECE', 
            ],
            [
                'course_name' => 'Bachelor of Science Mechanical Engineering',
                'course_acronym' => 'BSME', 
            ],
            [
                'course_name' => 'Bachelor of Science in Business Administration Major in Human Resource Development Management',
                'course_acronym' => 'BSBA-HRDM', 
            ],
            [
                'course_name' => 'Bachelor of Science in Business Administration Major in Marketing Management',
                'course_acronym' => 'BSBA-MM', 
            ],
            [
                'course_name' => 'Bachelor of Science in Office Administration Major in Legal Transcription',
                'course_acronym' => 'BSOA-LT', 
            ],
            [
                'course_name' => 'Bachelor of Secondary Education Major in English',
                'course_acronym' => 'BSED-English', 
            ],
            [
                'course_name' => 'Bachelor of Secondary Education Major in Mathematics',
                'course_acronym' => 'BSED-Mathematics', 
            ],
            [
                'course_name' => 'Bachelor of Science in Information Technology',
                'course_acronym' => 'BSIT', 
            ],
            [
                'course_name' => 'Diploma in Office Management Technology with Specialization in Legal Office Management',
                'course_acronym' => 'DOMT-LOM', 
            ],
            [
                'course_name' => 'Diploma in Information Communication Technology',
                'course_acronym' => 'DICT', 
            ],
        ];
        DB::table('courses')->insert($data);
    }
}
