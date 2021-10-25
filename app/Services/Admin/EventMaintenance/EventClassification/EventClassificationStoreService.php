<?php

namespace App\Services\Admin\EventMaintenance\EventClassification;

use App\Models\EventClassification;

use App\Services\NotificationServices\Admin\AdminNotificationService;

class EventClassificationStoreService
{
    /**
     * @param Request $request
     * Service to Store an Event Classification.
     * Returns Message on success
     * @return Array
     */
    public function store($request)
    {
        try 
        {
            $eventClassification = EventClassification::create([
                'classification' => $request->input('classification'),
                'helper' => $request->input('helper', NULL),
            ]);

            $adminNotificationService = new AdminNotificationService();
            $adminNotificationService->sendNotification(
                'All', 
                'SYSTEM: Added an Event Classification',
                'The Administrator has added a new Event Classification (' . $eventClassification->classification . '). Go to Event Creation Page to view it.',
                1,
            );
                
            return ['success' => 'Added the Event Classification Successfully.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in adding Event Classification:' . $e->getMessage()];
        }
    }
}
