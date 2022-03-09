<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = 1; // Active
        $course = 9; // BSIT
        $gender = 1; // Male
        $currentTime = Carbon::now();
        $data = [
            [
                //1
                'course_id' => NULL,
                'gender_id' => NULL, 
                'email' => 'super-admin@email.com', 
                'password' => Hash::make('super-admin@email.com'),
                'student_number' => NULL, 
                'first_name' => 'Super Admin',
                'middle_name' => 'I',
                'last_name' => 'Am',
                'date_of_birth' => '2000-01-01',
                'mobile_number' => '+639123456124',
                'address' => 'Taguig',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => $status,
                'year_and_section' => NULL,
            ],
            [
                //2
                'course_id' => $course,
                'gender_id' => $gender,
                'email' => 'bsit-homepage@email.com', 
                'password' => Hash::make('bsit-homepage@email.com'),
                'student_number' => '2018-12346-TG-0', 
                'first_name' => 'John',
                'middle_name' => 'Faraday',
                'last_name' => 'Doe',
                'date_of_birth' => '2000-01-01',
                'mobile_number' => '+639123456700',
                'address' => 'Taguig',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => $status,
                'year_and_section' => '4-1',
            ],
            [
                // 3qar
                'course_id' => 11,
                'gender_id' => 2,
                'email' => 'lullabyangela@gmail.com', 
                'password' => Hash::make('lullabyangela@gmail.com'),
                'student_number' => '2019-00404-TG-0', 
                'first_name' => 'Victoria Angela Marie',
                'middle_name' => 'Aquino',
                'last_name' => 'Dolor',
                'date_of_birth' => '2000-11-04',
                'mobile_number' => '+639164546149',
                'address' => '144 A. Reyes St., New Lower Bicutan, Taguig City',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => $status,
                'year_and_section' => '3-1',
            ],
            [
                //4 qar
                'course_id' => $course,
                'gender_id' => $gender, 
                'email' => 'jaceamaguin@gmail.com', 
                'password' => Hash::make('jaceamaguin@gmail.com'),
                'student_number' => '2018-00167-TG-0', 
                'first_name' => 'Juan Carlos',
                'middle_name' => NULL,
                'last_name' => 'Amaguin',
                'date_of_birth' => '1998-11-08',
                'mobile_number' => '+639175391998',
                'address' => '20 Kirishima St. BF Thai Las Piñas City',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => $status,
                'year_and_section' => '4-1',
            ],
            [
                //5
                'course_id' => $course,
                'gender_id' => $gender,
                'email' => 'bsit-membership@email.com', 
                'password' => Hash::make('bsit-membership@email.com'),
                'student_number' => '2018-12345-TG-0', 
                'first_name' => 'John',
                'middle_name' => 'Faraday',
                'last_name' => 'Doe',
                'date_of_birth' => '2000-01-01',
                'mobile_number' => '+639123456700',
                'address' => 'Taguig',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => $status,
                'year_and_section' => '4-1',
            ],
            [
                //6
                'course_id' => $course,
                'gender_id' => $gender,
                'email' => 'bsit-gpoa@email.com', 
                'password' => Hash::make('bsit-gpoa@email.com'),
                'student_number' => '2018-12348-TG-0', 
                'first_name' => 'John',
                'middle_name' => 'Faraday',
                'last_name' => 'Doe',
                'date_of_birth' => '2000-01-01',
                'mobile_number' => '+639123456700',
                'address' => 'Taguig',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => $status,
                'year_and_section' => '4-1',
            ],
            [
                //7
                'course_id' => $course,
                'gender_id' => $gender,
                'email' => 'bsit-finance@email.com', 
                'password' => Hash::make('bsit-finance@email.com'),
                'student_number' => '2018-12347-TG-0', 
                'first_name' => 'Ian Angelo',
                'middle_name' => NULL,
                'last_name' => 'Nierva',
                'date_of_birth' => '2000-01-01',
                'mobile_number' => '+639123456700',
                'address' => 'Taguig',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => $status,
                'year_and_section' => '4-1',
            ],
            [
                //8 normal user
                'course_id' => $course,
                'gender_id' => $gender, 
                'email' => 'bsit-member@email.com', 
                'password' => Hash::make('bsit-member@email.com'),
                'student_number' => '2018-00012-TG-0', 
                'first_name' => 'Jon Jeremiah',
                'middle_name' => 'Espina',
                'last_name' => 'Bartolome',
                'date_of_birth' => '2000-01-01',
                'mobile_number' => '+639123456710',
                'address' => 'Taguig',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => $status, 
                'year_and_section' => '4-1',      
            ],
            [
                // 9 qar AVP Docu
                'course_id' => 11,
                'gender_id' => 1,
                'email' => 'bryantpaulbabac07302001@gmail.com', 
                'password' => Hash::make('bryantpaulbabac07302001@gmail.com'),
                'student_number' => '2020-00197-TG-0', 
                'first_name' => 'Bryant Paul',
                'middle_name' => 'Sana',
                'last_name' => 'Babac',
                'date_of_birth' => '2001-07-30',
                'mobile_number' => '+639667344635',
                'address' => 'Imus City, Cavite',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => $status,
                'year_and_section' => '3-1',
            ],
            [
                // 10 Adviser
                'course_id' => NULL,
                'gender_id' => NULL,
                'email' => 'adviser@email.com', 
                'password' => Hash::make('adviser@email.com'),
                'student_number' => NULL, 
                'first_name' => 'Adviser',
                'middle_name' => 'I',
                'last_name' => 'Am',
                'date_of_birth' => '2001-01-01',
                'mobile_number' => '+639667344637',
                'address' => 'Taguig',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => $status,
                'year_and_section' => NULL,
            ],
            
            //Jones additional users
            [
                //11  - BSA - Membership
                'course_id' => 1,
                'gender_id' => $gender,
                'email' => 'bsa-membership2@email.com', 
                'password' => Hash::make('bsa-membership2@email.com'),
                'student_number' => '2018-66666-TG-0', 
                'first_name' => 'JohnMBS2',
                'middle_name' => 'Faraday2',
                'last_name' => 'Doe2',
                'date_of_birth' => '2000-01-01',
                'mobile_number' => '+639123456666',
                'address' => 'Taguig',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => $status,
                'year_and_section' => '4-1',
            ],
            [
                //12 BSA - GPOA
                'course_id' => 1,
                'gender_id' => $gender,
                'email' => 'bsa-gpoa2@email.com', 
                'password' => Hash::make('bsa-gpoa2@email.com'),
                'student_number' => '2018-77777-TG-0', 
                'first_name' => 'JohnGPOA2',
                'middle_name' => 'Faraday2',
                'last_name' => 'Doe2',
                'date_of_birth' => '2000-01-01',
                'mobile_number' => '+639123457777',
                'address' => 'Taguig',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => $status,
                'year_and_section' => '4-1',
            ],

            [
                //13 ERG - MEMBERSHIP
                'course_id' => NULL,
                'gender_id' => $gender,
                'email' => 'erg-membership@email.com', 
                'password' => Hash::make('erg-membership@email.com'),
                'student_number' => NULL, 
                'first_name' => 'I',
                'middle_name' => 'Am',
                'last_name' => 'Erg',
                'date_of_birth' => '2000-01-01',
                'mobile_number' => '+639123457777',
                'address' => 'Taguig',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => $status,
                'year_and_section' => NULL,
            ],

            [
                //14 pupukaw - MEMBERSHIP
                'course_id' => NULL,
                'gender_id' => $gender,
                'email' => 'pupukaw-membership@email.com', 
                'password' => Hash::make('pupukaw-membership@email.com'),
                'student_number' => NULL, 
                'first_name' => 'I',
                'middle_name' => 'Am',
                'last_name' => 'Pupukaw',
                'date_of_birth' => '2000-01-01',
                'mobile_number' => '+639123457777',
                'address' => 'Taguig',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => $status,
                'year_and_section' => NULL,
            ],
            [
                //15 - Director
                'course_id' => NULL,
                'gender_id' => $gender,
                'email' => 'director@email.com', 
                'password' => Hash::make('director@email.com'),
                'student_number' => NULL, 
                'first_name' => 'I',
                'middle_name' => 'Am',
                'last_name' => 'Director',
                'date_of_birth' => '2000-01-01',
                'mobile_number' => '+639123457777',
                'address' => 'Taguig',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => $status,
                'year_and_section' => NULL,
            ],

            // Bernadeth Canlas Account
            [
                //16 - Head of Student Services
                'course_id' => NULL,
                'gender_id' => 2,
                'email' => 'brndtt_canlas@yahoo.com', 
                'password' => Hash::make('brndtt_canlas@yahoo.com'),
                'student_number' => 'BC-96030-TG', 
                'first_name' => 'Bernadette',
                'middle_name' => 'Ignacio',
                'last_name' => 'Canlas',
                'date_of_birth' => '2000-11-06',
                'mobile_number' => '+639267008824',
                'address' => 'Taguig',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => $status,
                'year_and_section' => NULL,
            ],

        ];

        DB::table('users')->insert($data);
    }
}