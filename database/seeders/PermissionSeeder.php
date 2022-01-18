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
        ];
        DB::table('permissions')->insert($data);
    }
}
