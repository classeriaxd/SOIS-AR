<?php

namespace App\Services\Admin\AccomplishmentReportMaintenance\TabularColumn;

use App\Models\TabularTable;
use App\Models\TabularColumn;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class TabularColumnUpdateService
{
    /**
     * @param Collection $tabularTable, Collection $tabularColumn, Request $request
     * Service to Update a Tabular AR Column.
     * Returns Message on success
     * @return Array
     */
    public function update(TabularTable $tabularTable, TabularColumn $tabularColumn, $request): array
    {
        try 
        {
            $tabularColumn->update([
                'tabular_column_name' => $request->input('tabularColumnName'),
                'description' => $request->input('description', NULL),
            ]);
            
            // Notify All Documentation Officers
            if ($request->has('notify')) 
            {
                $adminNotificationService = new AdminNotificationService();
                $adminNotificationService->sendNotification(
                    'All', 
                    'SYSTEM: Update on Tabular AR Column',
                    'The Administrator has made changes to an Tabular AR Column on '. $tabularTable->tabular_table_name . '(' . $tabularColumn->tabular_column_name . ').',
                    1,
                );
            }
            
            return ['success' => 'Updated the Tabular AR Column Successfully. Please inform IT Personnel to adjust the tables in code.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Updating Tabular AR Column:' . $e->getMessage()];
        }
            
    }
}
