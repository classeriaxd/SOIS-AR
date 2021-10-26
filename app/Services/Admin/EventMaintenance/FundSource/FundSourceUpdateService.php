<?php

namespace App\Services\Admin\EventMaintenance\FundSource;

use App\Models\FundSource;
use Illuminate\Support\Str;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class FundSourceUpdateService
{
    /**
     * @param Collection $fundSource, Request $request
     * Service to Update a Fund Source.
     * Returns Message on success
     * @return Array
     */
    public function update(FundSource $fundSource, $request): array
    {
        try 
        {
            $fundSource->update([
                'fund_source' => $request->input('fundSource'),
                'helper' => $request->input('helper', NULL),
            ]);
            
            // Notify All Documentation Officers
            if ($request->has('notify')) 
            {
                $adminNotificationService = new AdminNotificationService();
                $adminNotificationService->sendNotification(
                    'All', 
                    'SYSTEM: Update on Fund Source',
                    'The Administrator has made changes to an Fund Source (' . $fundSource->fund_source . '). Go to Event Creation Page to view changes.',
                    1,
                );
            }

            return ['success' => 'Updated the Fund Source Successfully.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Updating Fund Source:' . $e->getMessage()];
        }
            
    }
}
