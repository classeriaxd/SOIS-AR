<?php

namespace App\Services\Admin\AccomplishmentReportMaintenance\TabularTable;

use App\Models\TabularTable;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class TabularTableStoreService
{
    /**
     * @param Request $request
     * Service to Store a Tabular AR Table.
     * Returns Message on success
     * @return Array
     */
    public function store($request): array
    {
        try 
        {
            $tabularTable = TabularTable::create([
                'tabular_table_name' => $request->input('tabularTableName'),
                'description' => $request->input('description', NULL),
                'reference_table_number' => $request->input('referenceTableNumber', NULL)
            ]);

            $adminNotificationService = new AdminNotificationService();
            $adminNotificationService->sendNotification(
                'All', 
                'SYSTEM: Added a Tabular AR Table',
                'The Administrator has added a new Tabular AR Table (' . $tabularTable->tabular_table_name . ').',
                1,
            );
                
            return ['success' => 'Added the Tabular AR Table Successfully. Please inform IT Personnel to adjust the tables in code.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in adding Tabular AR Table:' . $e->getMessage()];
        }
    }
}
