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
            ArticleTypeSeeder::class,
            AssetTypeSeeder::class,
            GenderSeeder::class,
            OrganizationTypeSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            AccomplishmentReportTypeSeeder::class,
            PageTypeSeeder::class,
            
            OrganizationSeeder::class,
            PageSeeder::class,
            SocialMediaSeeder::class,
            SoisLinkSeeder::class,
            
            CourseSeeder::class,

            OrganizationDocumentTypeSeeder::class,
            OrgSocialSeeder::class,
            UserSeeder::class,
            OrganizationAssetSeeder::class,

            PermissionRoleSeeder::class,
            PermissionUserSeeder::class,
            RoleUserSeeder::class,
            SoisGateSeeder::class,

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
