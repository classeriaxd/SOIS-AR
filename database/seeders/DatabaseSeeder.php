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
            AssetTypeSeeder::class,
            GenderSeeder::class,
            OrganizationTypeSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            AccomplishmentReportTypeSeeder::class,
            
            OrganizationSeeder::class,
            
            CourseSeeder::class,

            OrganizationAssetSeeder::class,
            OrganizationDocumentTypeSeeder::class,
            UserSeeder::class,

            PermissionRoleSeeder::class,
            PermissionUserSeeder::class,
            RoleUserSeeder::class,

            PositionCategorySeeder::class,
            PositionTitleSeeder::class,
            OfficerSeeder::class,
            
            LevelSeeder::class,
            FundSourceSeeder::class,
            EventCategorySeeder::class,
            EventRoleSeeder::class,
            EventNatureSeeder::class,
            EventClassificationSeeder::class,
            EventDocumentTypeSeeder::class,
            StudentAccomplishmentDocumentTypeSeeder::class,
            SchoolYearSeeder::class,
            
            TabularTableSeeder::class,
            TabularColumnSeeder::class,

            EventSignaturesSeeder::class,
        ]);
    }
}
