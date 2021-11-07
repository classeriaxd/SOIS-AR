<?php

namespace App\Services\Admin\EventMaintenance\EventDocumentType;

use App\Models\EventDocumentType;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class EventDocumentTypeDeleteService
{
    /**
     * @param Collection $documentType, Request $request
     * Service to Soft Delete an event document type.
     * Returns message on success.
     * @return Array
     */
    public function delete(EventDocumentType $documentType, $request): array
    {
        try 
        {
            $documentType->delete();
            
            // Notify All Documentation Officers
            $adminNotificationService = new AdminNotificationService();
            $adminNotificationService->sendNotification(
                'All', 
                $request->input('notificationTitle'),
                $request->input('notificationDescription'),
                1,
            );

            return ['success' => 'Successfully deleted Event Document Type. Notifications are sent to all Organization Officers'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Deleting Event Document Type:' . $e->getMessage()];
        }
    }
}
