<?php

namespace App\Services\Admin\EventMaintenance\EventClassification;

use App\Models\EventClassification;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class EventClassificationDeleteService
{
    /**
     * @param Collection $classification, Request $request
     * Service to Soft Delete an event classification.
     * Returns message on success.
     * @return Array
     */
    public function delete(EventClassification $classification, $request)
    {
        try 
        {
            $classification->delete();
            
            // Notify All Documentation Officers
            $adminNotificationService = new AdminNotificationService();
            $adminNotificationService->sendNotification(
                'All', 
                $request->input('notificationTitle'),
                $request->input('notificationDescription'),
                1,
            );

            return ['success' => 'Successfully deleted Event Classification. Notifications are sent to all Organization Officers'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Deleting Event Classification:' . $e->getMessage()];
        }
    }
}
