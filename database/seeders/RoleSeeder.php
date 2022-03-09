<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
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
            ['role' => 'Super Admin', 'description' => 'Super Admin - Bernadeth Canlas, Student Affairs.'],
            // 2
            ['role' => 'Home Page Admin', 'description' => 'Home Page Admin - PIO assigned to manage Home Page Maintenance of each organization.'],
            // 3
            ['role' => 'AR Officer Admin', 'description' => 'AR Admin - Documentation Officer assigned for managing Accomplishment Reports for each organization.'],
            // 4
            ['role' => 'AR President Admin', 'description' => 'AR Admin - Organization President Assigned for reviewing Accomplishment Reports.'],
            // 5
            ['role' => 'Membership Admin', 'description' => 'Membership Admin - Finance Officer assigned to manage Membership Applications of each organization.'],
            // 6
            ['role' => 'GPOA Admin', 'description' => 'GPOA Admin - Documentation Officer assigned for managing GPOA for each organization.'],
            // 7
            ['role' => 'Finance Admin', 'description' => 'Finance Officer assigned to manage Financial Statements of each organization.'],
            // 8
            ['role' => 'User', 'description' => 'Members of the Organizations in PUP Taguig'],
            // 9
            ['role' => 'Adviser', 'description' => 'Adviser of an Organization in PUP Taguig'],
            // 10
            ['role' => 'Director', 'description' => 'Director of the PUP Taguig'],
            // 11 Ma'am Bernadeth Canlas Role
            ['role' => 'Head of Student Services', 'description' => 'Head of the Student Services of PUP Taguig'],
        ];
        DB::table('roles')->insert($data);
    }
}
