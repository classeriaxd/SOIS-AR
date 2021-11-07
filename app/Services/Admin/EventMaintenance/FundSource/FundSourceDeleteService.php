<?php

namespace App\Services\Admin\EventMaintenance\FundSource;

use App\Models\FundSource;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class FundSourceDeleteService
{
    /**
     * @param Collection $fundSource, Request $request
     * Service to Soft Delete a fund source.
     * Returns message on success.
     * @return Array
     */
    public function delete(FundSource $fundSource, $request): array
    {
        try 
        {
            $fundSource->delete();
            
            // Notify All Documentation Officers
            $adminNotificationService = new AdminNotificationService();
            $adminNotificationService->sendNotification(
                'All', 
                $request->input('notificationTitle'),
                $request->input('notificationDescription'),
                1,
            );

            return ['success' => 'Successfully deleted Fund Source. Notifications are sent to all Organization Officers'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Deleting Fund Source:' . $e->getMessage()];
        }
    }
}
