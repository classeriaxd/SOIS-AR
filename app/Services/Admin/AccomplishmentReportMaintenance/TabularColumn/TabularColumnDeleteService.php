<?php

namespace App\Services\Admin\AccomplishmentReportMaintenance\TabularColumn;

use App\Models\TabularTable;
use App\Models\TabularColumn;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class TabularColumnDeleteService
{
    /**
     * @param Collection $tabularTable, Collection $tabularColumn, Request $request
     * Service to Soft Delete a Tabular AR Column.
     * Returns message on success.
     * @return Array
     */
    public function delete(TabularTable $tabularTable, TabularColumn $tabularColumn, $request): array
    {
        try 
        {
            $tabularColumn->delete();
            
            // Notify All Documentation Officers
            $adminNotificationService = new AdminNotificationService();
            $adminNotificationService->sendNotification(
                'All', 
                $request->input('notificationTitle'),
                $request->input('notificationDescription'),
                1,
            );
            //insert table name column nme
            return ['success' => 'Successfully deleted Tabular AR Column ('. $tabularColumn->tabular_column_name. ') in '. $tabularTable->tabular_table_name . '. Notifications are sent to all Organization Officers. Please inform IT Personnel to adjust the tables in code.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Deleting Tabular AR Column:' . $e->getMessage()];
        }
    }
}
