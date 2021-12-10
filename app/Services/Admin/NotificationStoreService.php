<?php

namespace App\Services\Admin;

use App\Models\Notification;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class NotificationStoreService
{
    /**
     * @param Request $request
     * Service to Send Notification to Org Officers/President.
     * Returns Message on success
     * @return Array
     */
    public function store($request): array
    {
        try 
        {
            $adminNotificationService = new AdminNotificationService();
            $adminNotificationService->sendNotificationToOrganization($request);
                
            return ['success' => 'Sent Notifications Successfully.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in sending notifications:' . $e->getMessage()];
        }
    }
}
