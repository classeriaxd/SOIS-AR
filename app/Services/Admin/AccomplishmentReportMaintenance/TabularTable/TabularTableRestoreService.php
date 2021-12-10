<?php

namespace App\Services\Admin\AccomplishmentReportMaintenance\TabularTable;

use App\Models\TabularTable;

class TabularTableRestoreService
{
    /**
     * Service to Restore soft deleted tabular table.
     * Returns message on success.
     * @return Array
     */
    public function restore(TabularTable $tabularTable): array
    {
        try 
        {
            $tabularTable->restore();

            return ['success' => 'Successfully restored Tabular Table.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Restoring Tabular Table:' . $e->getMessage()];
        }
    }
}
