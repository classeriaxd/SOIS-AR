<?php

namespace App\Services\Admin\AccomplishmentReportMaintenance\TabularTable;

use App\Models\TabularTable;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class TabularTableUpdateService
{
    /**
     * @param Collection $tabularTable, Request $request
     * Service to Update a Tabular AR Table.
     * Returns Message on success
     * @return Array
     */
    public function update(TabularTable $tabularTable, $request): array
    {
        try 
        {
            $tabularTable->update([
                'tabular_table_name' => $request->input('tabularTableName'),
                'description' => $request->input('description', NULL),
                'reference_table_number' => $request->input('referenceTableNumber', NULL)
            ]);
            
            // Notify All Documentation Officers
            if ($request->has('notify')) 
            {
                $adminNotificationService = new AdminNotificationService();
                $adminNotificationService->sendNotification(
                    'All', 
                    'SYSTEM: Update on Tabular AR Table',
                    'The Administrator has made changes to an Tabular AR Table (' . $tabularTable->tabular_table_name . ').',
                    1,
                );
            }

            return ['success' => 'Updated the Tabular AR Table Successfully. Please inform IT Personnel to adjust the tables in code.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Updating Tabular AR Table:' . $e->getMessage()];
        }
            
    }
}
