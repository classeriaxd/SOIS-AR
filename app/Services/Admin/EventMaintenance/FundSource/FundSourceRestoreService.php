<?php

namespace App\Services\Admin\EventMaintenance\FundSource;

use App\Models\FundSource;

class FundSourceRestoreService
{
    /**
     * Service to Restore soft deleted event fund source.
     * Returns message on success.
     * @return Array
     */
    public function restore(FundSource $fundSource): array
    {
        try 
        {
            $fundSource->restore();

            return ['success' => 'Successfully restored Event Fund Source.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Restoring Event Fund Source:' . $e->getMessage()];
        }
    }
}
