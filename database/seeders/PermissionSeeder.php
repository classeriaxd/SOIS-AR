<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermissionSeeder extends Seeder
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
            // EventsController
                [
                    // 1
                    'name' => 'AR-Create_Event', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
                [
                    // 2
                    'name' => 'AR-Edit_Event', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
                [
                    // 3
                    'name' => 'AR-Delete_Event', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
                [
                    // 4
                    'name' => 'AR-View_Event', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],

            // EventImagesController
                [
                    // 5
                    'name' => 'AR-Create_Event_Image', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
                [
                    // 6
                    'name' => 'AR-Edit_Event_Image', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
                [
                    // 7
                    'name' => 'AR-Delete_Event_Image', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
                [
                    // 8
                    'name' => 'AR-View_Event_Image', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],

            // EventDocumentsController
                [
                    // 9
                    'name' => 'AR-Create_Event_Document', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
                [
                    // 10
                    'name' => 'AR-Download_Event_Document', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
                [
                    // 11
                    'name' => 'AR-Edit_Event_Document', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
                [
                    // 12
                    'name' => 'AR-Delete_Event_Document', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
                [
                    // 13
                    'name' => 'AR-View_Event_Document', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],

            // AccomplishmentReportsController
                [
                    // 14
                    'name' => 'AR-Create_Accomplishment_Report', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
                [
                    // 15
                    'name' => 'AR-Review_Accomplishment_Report', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
                [
                    // 16
                    'name' => 'AR-Download_Accomplishment_Report', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
                [
                    // 17
                    'name' => 'AR-View_Accomplishment_Report', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],

            // NotificationsController
                [
                    // 18
                    'name' => 'AR-View_Notification', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
                [
                    // 19
                    'name' => 'AR-Read_Notification', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],

            // OrganizationDocumentsController
                [
                    // 20
                    'name' => 'AR-Create_Organization_Document', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
                [
                    // 21
                    'name' => 'AR-Edit_Organization_Document', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
                [
                    // 22
                    'name' => 'AR-Delete_Organization_Document', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
                [
                    // 23
                    'name' => 'AR-View_Organization_Document', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],

            // OrganizationDocumentTypesController
                [
                    // 24
                    'name' => 'AR-Create_Organization_Document_Type', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
                [
                    // 25
                    'name' => 'AR-Edit_Organization_Document_Type', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
                [
                    // 26
                    'name' => 'AR-Delete_Organization_Document_Type', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
                [
                    // 27
                    'name' => 'AR-View_Organization_Document_Type', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],

            // StudentAccomplishmentsController
                [
                    // 28
                    'name' => 'AR-Create_Student_Accomplishment', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
                [
                    // 29
                    'name' => 'AR-Review_Student_Accomplishment', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
                [
                    // 30
                    'name' => 'AR-View_Student_Accomplishment', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],

            // View Home
                [
                    // 31
                    'name' => 'AR-View_Home', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],

            // View Admin Home
                [
                    // 32
                    'name' => 'AR-Super-Admin-View_Admin_Home', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],

            // Admin //
            // Manage Accomplishment Report Maintenance
                [
                    // 33
                    'name' => 'AR-Super-Admin-Manage_Accomplishment_Report', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // Manage Event Maintenance
                [
                    // 34
                    'name' => 'AR-Super-Admin-Manage_Event', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // Admin Organization Views
                [
                    // 35
                    'name' => 'AR-Super-Admin-Manage_Organization', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // Admin Notification
                [
                    // 36
                    'name' => 'AR-Super-Admin-Manage_Notification', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // Manage Roles and Permissions
                [
                    // 37
                    'name' => 'AR-Super-Admin-Manage_Roles_and_Permissions', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // AR Officer Manage Officer Signatures
                [
                    // 38
                    'name' => 'AR-Manage_Officer_Signatures', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],

            // Homepage permissions
                // HP create news
                [
                    // 39
                    'name' => 'HP-Create_News_Article', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Edit News
                [
                    // 40
                    'name' => 'HP-Edit_News_Article', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Delete News
                [
                    // 41
                    'name' => 'HP-Delete_News_Article', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Read News
                [
                    // 42
                    'name' => 'HP-View_News_Article', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP create Announcement
                [
                    // 43
                    'name' => 'HP-Create_Announcement_Article', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Edit Announcement
                [
                    // 44
                    'name' => 'HP-Edit_Announcement_Article', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Delete Announcement
                [
                    // 45
                    'name' => 'HP-Delete_Announcement_Article', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Read Announcement
                [
                    // 46
                    'name' => 'HP-View_Announcement_Article', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP create Roles
                [
                    // 47
                    'name' => 'HP-Create_Roles', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Edit Roles
                [
                    // 48
                    'name' => 'HP-Edit_Roles', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Delete Roles
                [
                    // 49
                    'name' => 'HP-Delete_Roles', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Read Roles
                [
                    // 50
                    'name' => 'HP-View_Roles', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP create permission
                [
                    // 51
                    'name' => 'HP-Create_Permission', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Edit permission
                [
                    // 52
                    'name' => 'HP-Edit_Permission', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Delete permission
                [
                    // 53
                    'name' => 'HP-Delete_Permission', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Read permission
                [
                    // 54
                    'name' => 'HP-View_Permission', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP create ORganization Page
                [
                    // 55
                    'name' => 'HP-Create_Organization_Page', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Edit ORganization Page
                [
                    // 56
                    'name' => 'HP-Edit_Organization_Page', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Delete ORganization Page
                [
                    // 57
                    'name' => 'HP-Delete_Organization_Page', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Read ORganization Page
                [
                    // 58
                    'name' => 'HP-View_Organization_Page', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP create System Link
                [
                    // 59
                    'name' => 'HP-Create_System_Links', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Edit System Link
                [
                    // 60
                    'name' => 'HP-Edit_System_Links', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Delete System Link
                [
                    // 61
                    'name' => 'HP-Delete_System_Links', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Read System Link
                [
                    // 62
                    'name' => 'HP-View_System_Links', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP create System Asset types
                [
                    // 63
                    'name' => 'HP-Create_System_Asset_Types', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Edit System Asset types
                [
                    // 64
                    'name' => 'HP-Edit_System_Asset_Types', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Delete System Asset types
                [
                    //65
                    'name' => 'HP-Delete_System_Asset_Types', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Read System Asset types
                [
                    // 66
                    'name' => 'HP-View_System_Asset_Types', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP create Web Page Type
                [
                    // 67
                    'name' => 'HP-Create_WebPage_Type', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Edit Web Page Type
                [
                    // 68
                    'name' => 'HP-Edit_WebPage_Type', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Delete Web Page Type
                [
                    // 69
                    'name' => 'HP-Delete_WebPage_Type', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Read Web Page Type
                [
                    // 70
                    'name' => 'HP-View_WebPage_Type', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Read Academic Members
                [
                    // 71
                    'name' => 'HP-View_Academic_Members', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ], 
            // HP Read Non-Academic Members
                [
                    // 72
                    'name' => 'HP-View_Non_Academic_Members', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Access Sois Links Button
                [
                    // 73
                    'name' => 'HP-Access_Sois_General_Links', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Access Financial Link
                [
                    // 74
                    'name' => 'HP-Access_Sois_Financial_Links', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Access AR Link
                [
                    // 75
                    'name' => 'HP-Access_Sois_AR_Links', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Access GPOA Link
                [
                    // 76
                    'name' => 'HP-Access_Sois_GPOA_Links', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Access Membership Link
                [
                    // 77
                    'name' => 'HP-Access_Sois_Membership_Links', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],  
            // HP create user
                [
                    // 78
                    'name' => 'HP-Create_User', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Edit user
                [
                    // 79
                    'name' => 'HP-Edit_User', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Delete user
                [
                    // 80
                    'name' => 'HP-Delete_User', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
            // HP Read user
                [
                    // 81
                    'name' => 'HP-View_User', 
                    'created_at' => $currentTime, 'updated_at' => $currentTime,
                ],
        ];
        DB::table('permissions')->insert($data);
    }
}
