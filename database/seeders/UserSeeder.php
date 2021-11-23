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
            ],
            [
                // 3qar
                'course_id' => $course,
                'gender_id' => $gender,
                'email' => 'bsit@email.com', 
                'password' => Hash::make('bsit@email.com'),
                'student_number' => '2018-00001-TG-0', 
                'first_name' => 'Victoria Angela Marie',
                'middle_name' => 'Aquino',
                'last_name' => 'Dolor',
                'date_of_birth' => '2000-01-01',
                'mobile_number' => '+639123456700',
                'address' => 'Taguig',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => $status,
            ],
            [
                //4 qar
                'course_id' => $course,
                'gender_id' => $gender, 
                'email' => 'bsit-president@email.com', 
                'password' => Hash::make('bsit-president@email.com'),
                'student_number' => '2018-000013-TG-0', 
                'first_name' => 'Juan Carlos',
                'middle_name' => NULL,
                'last_name' => 'Amaguin',
                'date_of_birth' => '2000-01-01',
                'mobile_number' => '+639123456123',
                'address' => 'Taguig',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'status' => $status,
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
            ],
            
            
            
        ];

        DB::table('users')->insert($data);
    }
}