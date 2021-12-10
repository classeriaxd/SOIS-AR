<?php

namespace App\Services\Admin\AccomplishmentReportMaintenance\TabularColumn;

use App\Models\TabularColumn;

class TabularColumnRestoreService
{
    /**
     * Service to Restore soft deleted tabular column.
     * Returns message on success.
     * @return Array
     */
    public function restore(TabularColumn $tabularColumn): array
    {
        try 
        {
            $tabularColumn->restore();

            return ['success' => 'Successfully restored Tabular Column.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Restoring Tabular Column:' . $e->getMessage()];
        }
    }
}
