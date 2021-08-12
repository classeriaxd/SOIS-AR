<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            CourseSeeder::class,
            UserSeeder::class,
            OrganizationSeeder::class,
            CourseOrganizationSeeder::class,
            PositionTitleSeeder::class,
            UserPositionSeeder::class,
            
            //EventSeeder::class,
        ]);
    }
}
