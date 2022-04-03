<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SoisSubGateSeeder extends Seeder
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
                'sois_sub_gates_id' => '1',
                'sub_under_for' => '1',
                'sub_name' => 'Event Reports',
                'sub_description' => 'Event Reports',
                'sub_link' => 'https://sois-ar.puptaguigcs.net/events',
                'status' => '1',
                'role_id' => '1',
                'user_id' => '3',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'sois_sub_gates_id' => '2',
                'sub_under_for' => '1',
                'sub_name' => 'Create Event Reports',
                'sub_description' => 'Create Event Reports',
                'sub_link' => 'https://sois-ar.puptaguigcs.net/events/create',
                'status' => '1',
                'role_id' => '1',
                'user_id' => '3',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'sois_sub_gates_id' => '3',
                'sub_under_for' => '1',
                'sub_name' => 'Student Accomplishments',
                'sub_description' => 'Student Accomplishments',
                'sub_link' => 'https://sois-ar.puptaguigcs.net/students/accomplishments',
                'status' => '1',
                'role_id' => '1',
                'user_id' => '3',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'sois_sub_gates_id' => '4',
                'sub_under_for' => '1',
                'sub_name' => 'Create Student Accomplishments',
                'sub_description' => 'Create Student Accomplishments',
                'sub_link' => 'https://sois-ar.puptaguigcs.net/students/accomplishments/create',
                'status' => '1',
                'role_id' => '1',
                'user_id' => '3',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'sois_sub_gates_id' => '5',
                'sub_under_for' => '1',
                'sub_name' => 'Manage CS Officer Signature',
                'sub_description' => 'Manage CS Officer Signature',
                'sub_link' => 'https://sois-ar.puptaguigcs.net/maintenances/cs/officerSignatures',
                'status' => '1',
                'role_id' => '1',
                'user_id' => '3',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
            [
                'sois_sub_gates_id' => '6',
                'sub_under_for' => '1',
                'sub_name' => 'Organization Documents',
                'sub_description' => 'Organization Documents',
                'sub_link' => 'https://sois-ar.puptaguigcs.net/documents/cs',
                'status' => '1',
                'role_id' => '1',
                'user_id' => '3',
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ],
        ];
        DB::table('sois_sub_gates')->insert($data);
    }
}
