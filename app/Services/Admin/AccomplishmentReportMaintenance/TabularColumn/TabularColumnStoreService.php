<?php

namespace App\Services\Admin\AccomplishmentReportMaintenance\TabularColumn;

use App\Models\TabularTable;
use App\Models\TabularColumn;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class TabularColumnStoreService
{
    /**
     * @param Collection $tabularTable, Request $request
     * Service to Store a Tabular AR Column.
     * Returns Message on success
     * @return Array
     */
    public function store(TabularTable $tabularTable, $request): array
    {
        try 
        {
            $tabularColumn = TabularColumn::create([
                'tabular_table_id' => $tabularTable->tabular_table_id,
                'tabular_column_name' => $request->input('tabularColumnName'),
                'description' => $request->input('description', NULL),
            ]);

            $adminNotificationService = new AdminNotificationService();
            $adminNotificationService->sendNotification(
                'All', 
                'SYSTEM: Added a Tabular AR Column',
                'The Administrator has added a new Tabular AR Column on ' . $tabularTable->tabular_table_name . ' (' . $tabularColumn->tabular_column_name . ').',
                1,
            );
            
            return ['success' => 'Added the Tabular AR Column Successfully. Please inform IT Personnel to adjust the tables in code.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in adding Tabular AR Column:' . $e->getMessage()];
        }
    }
}
