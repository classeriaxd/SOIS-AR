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
            OrganizationSeeder::class,
            CourseSeeder::class,
            UserSeeder::class,
            PositionTitleSeeder::class,
            UserPositionSeeder::class,
            //OrganizationDocumentTypeSeeder::class,
            OrganizationAssetSeeder::class,
            EventCategorySeeder::class,
            EventRoleSeeder::class,
            EventDocumentTypeSeeder::class,
            //EventSeeder::class,
            SchoolYearSeeder::class,
        ]);
    }
}
