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
            OrganizationTypeSeeder::class,
            OrganizationAssetTypeSeeder::class,
            OrganizationSeeder::class,
            CourseSeeder::class,
            GenderSeeder::class,
            UserSeeder::class,
            PositionTitleSeeder::class,
            UserPositionSeeder::class,
            OrganizationAssetSeeder::class,
            EventCategorySeeder::class,
            EventRoleSeeder::class,
            EventClassificationSeeder::class,
            EventNatureSeeder::class,
            EventDocumentTypeSeeder::class,
            SchoolYearSeeder::class,
            FundSourceSeeder::class,
            LevelSeeder::class,
            TabularTableSeeder::class,
            TabularColumnSeeder::class,
        ]);
    }
            //OrganizationDocumentTypeSeeder::class,
            //EventSeeder::class,
            //RoleUserSeeder::class,
}
