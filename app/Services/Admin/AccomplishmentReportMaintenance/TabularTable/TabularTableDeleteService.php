<?php

namespace App\Services\Admin\AccomplishmentReportMaintenance\TabularTable;

use App\Models\TabularTable;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class TabularTableDeleteService
{
    /**
     * @param Collection $tabularTable, Request $request
     * Service to Soft Delete a tabular table.
     * Returns message on success.
     * @return Array
     */
    public function delete(TabularTable $tabularTable, $request): array
    {
        try 
        {
            $tabularTable->delete();
            
            // Notify All Documentation Officers
            $adminNotificationService = new AdminNotificationService();
            $adminNotificationService->sendNotification(
                'All', 
                $request->input('notificationTitle'),
                $request->input('notificationDescription'),
                1,
            );

            return ['success' => 'Successfully deleted Tabular AR Table. Notifications are sent to all Organization Officers. Please inform IT Personnel to adjust the tables in code.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Deleting Tabular AR Table:' . $e->getMessage()];
        }
    }
}
